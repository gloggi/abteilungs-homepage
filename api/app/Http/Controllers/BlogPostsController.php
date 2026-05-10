<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Models\BlogPost;
use App\Services\PageItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostsController extends Controller
{
    protected $pageItemService;

    public function __construct(PageItemService $pageItemService)
    {
        $this->pageItemService = $pageItemService;
    }

    public function index(Request $request)
    {
        $query = BlogPost::query()->with('files', 'previewImage', 'tags');

        if ($request->has('search')) {
            $blogSearchResults = BlogPost::where('title', 'like', '%'.$request->get('search').'%')->pluck('id');
            $query = BlogPost::whereIn('id', $blogSearchResults);
        }

        if ($request->has('tags')) {
            $tags = $request->input('tags');
            if (is_array($tags) && count($tags) > 0) {
                $query->whereHas('tags', function ($q) use ($tags) {
                    $q->whereIn('tags.id', $tags);
                });
            }
        }

        if (! $request->input('dashboard')) {
            $query->where('active', true)
                ->where('published_at', '<=', now());
        }

        $perPage = $request->input('per_page', 3);
        $posts = $query->with('textItems')->orderBy('published_at', 'desc')->paginate($perPage)->withQueryString();

        return response()->json($posts);
    }

    public function store(StoreBlogPostRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        $blogPost = BlogPost::create($validatedData);

        $blogPost->files()->sync(array_column($request->input('files', []), 'id'));
        $blogPost->tags()->sync(array_column($request->input('tags', []), 'id'));

        if (isset($validatedData['page_items'])) {
            $this->pageItemService->syncItems($blogPost, $validatedData['page_items']);
        }

        return response()->json([
            'id' => $blogPost->id,
            'title' => $blogPost->title,
            'slug' => $blogPost->slug,
            'page_items' => $blogPost->getAllItems(),
            'tags' => $blogPost->tags,
        ], 201);
    }

    public function show($slugOrId)
    {
        $post = BlogPost::where('id', $slugOrId)
            ->orWhere('slug', $slugOrId)
            ->with('files', 'previewImage', 'tags')
            ->first();

        if (! $post) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }

        if (! Auth::check() && (! $post->active || ($post->published_at && $post->published_at > now()))) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }

        return response()->json(array_merge($post->toArray(), [
            'page_items' => $post->getAllItems(),
        ]));
    }

    public function update(UpdateBlogPostRequest $request, $id)
    {
        $post = BlogPost::find($id);
        if (! $post) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }

        $validatedData = $request->validated();
        $post->update($validatedData);
        $post->files()->sync(array_column($request->input('files', []), 'id'));
        $post->tags()->sync(array_column($request->input('tags', []), 'id'));

        if (isset($validatedData['page_items'])) {
            $currentItems = collect($post->getAllItems());
            $validatedItems = collect($validatedData['page_items']);

            $validatedIds = $validatedItems->pluck('id')->filter()->map(function ($id) {
                return (int) $id;
            });

            foreach ($currentItems as $item) {
                $found = $validatedItems->first(function ($valItem) use ($item) {
                    return isset($valItem['id']) && $valItem['id'] == $item->id && $valItem['type'] == $item->type;
                });

                if (! $found) {
                    $item->delete();
                }
            }

            $this->pageItemService->syncItems($post, $validatedData['page_items']);
        }

        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'page_items' => $post->getAllItems(),
            'tags' => $post->tags,
        ], 200);
    }

    public function destroy($id)
    {
        $post = BlogPost::find($id);
        if (! $post) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
