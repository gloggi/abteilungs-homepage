<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use App\Models\TextItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    protected $pageItemService;

    public function __construct(\App\Services\PageItemService $pageItemService)
    {
        $this->pageItemService = $pageItemService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Page::query();
        if ($request->has('search')) {
            $pageSearchResults = Page::search($request->get('search'))->get()->pluck('id');
            $textItemsSearchResults = TextItem::search($request->get('search'))->get()->pluck('page_id');
            $query = Page::whereIn('id', $pageSearchResults->merge($textItemsSearchResults));
        }
        $query = $query->with('files');
        if ($request->has('dashboard') && ! $user->hasRole('admin')) {
            $groupIds = $user->groups->pluck('id');
            $query->whereIn('group_id', $groupIds);
        }
        $perPage = $request->input('per_page', 1000);
        $pages = $query->orderBy('updated_at', 'desc')
            ->paginate($perPage);

        return response()->json($pages);
    }

    public function show($id, Request $request)
    {
        if ($id === '0') {
            $page = Page::whereNull('route')->orWhereIn('route', ['0', 'home', ''])->orderByRaw('CASE WHEN route IS NULL THEN 0 ELSE 1 END')->first();
        } else {
            $page = Page::where('id', $id)->orWhere('route', $id)->first();
        }

        if (! $page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $page->load('files');

        if ($page->password) {
            $token = $request->header('X-Page-Token');
            $authorized = $this->checkToken($token, $page->id);

            if (! $authorized) {
                if ($user = Auth::guard('sanctum')->user()) {
                    if ($user->hasRole('admin')) {
                        $authorized = true;
                    } elseif ($page->group_id && $user->groups->pluck('id')->contains($page->group_id)) {
                        $authorized = true;
                    }
                }
            }

            if (! $authorized) {
                return response()->json(['error' => 'Password required'], 403);
            }
        }

        $pageData = $page->toArray();
        $pageData['page_items'] = $page->getAllItems();

        return response()->json($pageData);
    }

    public function store(StorePageRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            if (isset($validatedData['group_id'])) {
                $groups = $user->groups->pluck('id');
                $groupId = $validatedData['group_id'];
                if (! $groups->contains($groupId)) {
                    return response()->json(['message' => 'Unauthorized'], 403);
                }
            }
        }
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $page = Page::create($validatedData);

        $page->files()->sync(array_column($request->input('files', []), 'id'));

        if (isset($validatedData['page_items'])) {
            $this->pageItemService->syncItems($page, $validatedData['page_items']);
        }

        return response()->json([
            'id' => $page->id,
            'title' => $page->title,
            'route' => $page->route,
            'page_items' => $page->getAllItems(),
        ], 201);
    }

    public function update(UpdatePageRequest $request, $id)
    {
        $page = Page::find($id);
        if (! $page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $validatedData = $request->validated();
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            $groups = $user->groups->pluck('id');
            $groupId = $validatedData['group_id'];
            if (! $groups->contains($groupId)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }
        $page->update($validatedData);
        $page->files()->sync(array_column($request->input('files', []), 'id'));

        if (isset($validatedData['page_items'])) {
            $currentItems = collect($page->getAllItems());
            $validatedItems = collect($validatedData['page_items']);

            $currentItemKeys = $currentItems->map(function ($item) {
                return ['id' => $item->id, 'type' => $item->type];
            });

            $validatedItemKeys = $validatedItems->map(function ($item) {
                return ['id' => $item['id'] ?? null, 'type' => $item['type']];
            });

            $idsToDelete = $currentItemKeys->filter(function ($currentKey) use ($validatedItemKeys) {
                return ! $validatedItemKeys->contains(function ($validatedKey) use ($currentKey) {
                    return $validatedKey['id'] === $currentKey['id'] && $validatedKey['type'] === $currentKey['type'];
                });
            });

            foreach ($currentItems as $item) {
                if ($idsToDelete->contains(['id' => $item->id, 'type' => $item->type])) {
                    $item->delete();
                    unset($item);
                }
            }

            $this->pageItemService->syncItems($page, $validatedData['page_items']);
        }

        $page = Page::find($id);

        return response()->json([
            'id' => $page->id,
            'title' => $page->title,
            'route' => $page->route,
            'page_items' => $page->getAllItems(),
        ], 200);
    }

    public function destroy($id)
    {
        $page = Page::find($id);
        if (! $page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            if ($page->group_id && ! $user->groups->pluck('id')->contains($page->group_id)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $items = $page->getAllItems();
        foreach ($items as $item) {
            $item->delete();
        }

        $page->delete();

        return response()->json(['message' => 'Page deleted successfully'], 200);
    }

    public function getPageToken(Request $request)
    {
        $route = $request->input('route');
        $page = Page::where('route', $route)->first();

        if (! $page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        $password = $request->input('password');
        error_log($page->password);

        if (! Hash::check($password, $page->password)) {
            return response()->json(['error' => 'Invalid password'], 403);
        }

        $payload = [
            'page_id' => $page->id,
            'issued_at' => Carbon::now()->timestamp,
            'expires_at' => Carbon::now()->addDay()->timestamp,
        ];

        $token = Crypt::encrypt($payload);

        return response()->json(['token' => $token]);
    }

    private function checkToken($token, $pageId)
    {
        if (! $token) {
            return false;
        }
        $payload = Crypt::decrypt($token);

        if (Carbon::now()->timestamp > $payload['expires_at'] || $payload['page_id'] !== $pageId) {
            return false;
        }

        return true;

    }
}
