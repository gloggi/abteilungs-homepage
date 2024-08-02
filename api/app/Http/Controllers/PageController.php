<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\CampItem;
use App\Models\FaqItem;
use App\Models\FilesItem;
use App\Models\FormItem;
use App\Models\GenericItem;
use App\Models\GroupEventsItem;
use App\Models\ImageItem;
use App\Models\LocationItem;
use App\Models\Page;
use App\Models\TextItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PageController extends Controller
{
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

        $this->createPageItemsFromValidatedData($page, $validatedData);

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

        $this->createPageItemsFromValidatedData($page, $validatedData);
        $page = Page::find($id);

        return response()->json([
            'id' => $page->id,
            'title' => $page->title,
            'route' => $page->route,
            'page_items' => $page->getAllItems(),
        ], 200);
    }

    public function show($routeOrId)
    {
        $routeOrId = $routeOrId == '0' ? null : $routeOrId;
        $user = Auth::user();

        $page = Page::with('files')
            ->where(function ($query) use ($routeOrId) {
                $query->where('route', $routeOrId)
                    ->orWhere('id', $routeOrId)
                    ->orWhere('route', Str::slug($routeOrId));
            })->first();
        if (! $page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
        if (! $user && $page->password && ! $this->checkToken(request()->input('token'), $page->id)) {
            return response()->json(array_merge($page->toArray(), [
                'page_items' => [
                    [
                        'id' => 0,
                        'type' => 'passwordItem',
                    ],
                ],
            ]), 200);
        }
        $pageItems = $page->getAllItems();
        foreach ($pageItems as $currentField) {
            if ($currentField->type == 'formItem' && $currentField->form) {
                unset($currentField->form->email);
                $currentField->form->fields = $currentField->form->getAllFields();
            }
        }

        return response()->json(array_merge($page->toArray(), [
            'page_items' => $pageItems,
        ]), 200);

    }

    public function destroy($id)
    {
        $page = Page::find($id);

        if (! $page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            $groups = $user->groups->pluck('id');
            $groupId = $page->group_id;
            if (! $groups->contains($groupId)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $page->delete();

        return response()->json(null, 204);
    }

    private function createPageItemsFromValidatedData(Page $page, $validatedData)
    {
        if (! isset($validatedData['page_items'])) {
            return;
        }
        $validatedData['page_items'] = collect($validatedData['page_items'])->sortBy('sort')->values()->all();
        $sort_counter = 0;
        foreach ($validatedData['page_items'] as $pageItemData) {
            switch ($pageItemData['type']) {
                case 'textItem':
                    TextItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'title' => $pageItemData['title'] ?? '',
                            'body' => $pageItemData['body'] ?? '',
                            'section_id' => $pageItemData['section_id'] ?? null,
                            'group_id' => $pageItemData['group_id'] ?? null,
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                        ]
                    );
                    break;
                case 'imageItem':
                    $imageItem = ImageItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                        ]
                    );
                    $fileIds = isset($pageItemData['files']) ? array_column($pageItemData['files'], 'id') : [];

                    if (isset($pageItemData['id'])) {
                        $imageItem->files()->sync($fileIds);
                    } else {
                        $imageItem->files()->attach($fileIds);
                    }
                    break;
                case 'formItem':
                    FormItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'form_id' => $pageItemData['form_id'] ?? null,
                        ]
                    );
                    break;
                case 'filesItem':
                    $imageItem = FilesItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'title' => $pageItemData['title'] ?? '',
                            'sort' => $sort_counter,
                        ]
                    );
                    $fileIds = isset($pageItemData['files']) ? array_column($pageItemData['files'], 'id') : [];

                    if (isset($pageItemData['id'])) {
                        $imageItem->files()->sync($fileIds);
                    } else {
                        $imageItem->files()->attach($fileIds);
                    }
                    break;
                case 'contactItem':
                    GenericItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'type' => 'contactItem',
                        ]
                    );

                    break;
                case 'groupsItem':
                    GenericItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'type' => 'groupsItem',
                        ]
                    );
                    break;
                case 'sectionsItem':
                    GenericItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'type' => 'sectionsItem',
                        ]
                    );
                    break;
                case 'campItem':
                    CampItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'group_id' => $pageItemData['group_id'] ?? null,
                        ]
                    );
                    break;
                case 'locationItem':
                    LocationItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'location_id' => $pageItemData['location_id'] ?? null,
                        ]
                    );
                    break;
                case 'faqItem':
                    FaqItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'faq_id' => $pageItemData['faq_id'] ?? null,
                        ]
                    );
                    break;
                case 'groupEventsItem':
                    GroupEventsItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'group_id' => $pageItemData['group_id'] ?? null,
                        ]
                    );
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported field type: {$pageItemData['type']}");
            }
            $sort_counter++;
        }
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
