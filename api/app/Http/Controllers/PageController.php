<?php
namespace App\Http\Controllers;


use App\Models\ImageItem;
use App\Models\TextItem;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller {

    public function index(Request $request) {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $pages = Page::paginate($perPage, ['*'], 'page', $page);
        $data = $pages->items();
        $meta = [
            'current_page' => $pages->currentPage(),
            'from' => $pages->firstItem(),
            'last_page' => $pages->lastPage(),
            'path' => $pages->path(),
            'per_page' => $pages->perPage(),
            'to' => $pages->lastItem(),
            'total' => $pages->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }
    public function store(Request $request) {

        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'page_items' => 'nullable|array',
            'page_items.*.id' => 'nullable',
            'page_items.*.sort' => 'nullable',
            'page_items.*.type' => 'required|string|in:textItem,imageItem',
            'page_items.*.title' => 'nullable',
            'page_items.*.body' => 'nullable',
            'page_items.*.file_id' => 'nullable'
        ]);

        $page = Page::create([
            'title' => $validatedData['title'],
            'route' => $validatedData['route'],
        ]);

        $this->createPageItemsFromValidatedData($page, $validatedData);

        return response()->json([
            'id' => $page->id,
            'title' => $page->title,
            'route' => $page->route,
            'page_items' => $page->getAllItems(),
        ], 201);
    }

    public function update(Request $request, $id) {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'page_items' => 'nullable|array',
            'page_items.*.id' => 'nullable',
            'page_items.*.sort' => 'nullable',
            'page_items.*.type' => 'required|string|in:textItem,imageItem',
            'page_items.*.title' => 'nullable',
            'page_items.*.body' => 'nullable',
            'page_items.*.files' => 'nullable'
        ]);

        $page = Page::find($id);
        $page->title = $validatedData['title'];
        $page->route = $validatedData['route'];
        $page->save();

        $this->createPageItemsFromValidatedData($page, $validatedData);

        $currentPageItems = $page->getAllItems();
        foreach($currentPageItems as $currentField) {
            $found = false;
            foreach($validatedData['page_items'] as $pageItemData) {
                if(!isset($pageItemData['id']) || $currentField->id == $pageItemData['id']) {
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                $currentField->delete();
            }
        }
        $page = Page::find($id);

        return response()->json([
            'id' => $page->id,
            'title' => $page->title,
            'route' => $page->route,
            'page_items' => $page->getAllItems(),
        ], 200);
    }

    public function show($id) {
        $page = Page::find($id);
        return response()->json(array_merge($page->toArray(), [
            'page_items' => $page->getAllItems(),
        ]), 200);

    }

    public function destroy($id) {
        $page = Page::find($id);
        $page->delete();
        return response()->json('Page removed successfully');
    }
    private function createPageItemsFromValidatedData(Page $page, $validatedData) {
        $validatedData['page_items'] = collect($validatedData['page_items'])->sortBy('sort')->values()->all();
        $sort_counter = 0;
        foreach($validatedData['page_items'] as $pageItemData) {
            switch($pageItemData['type']) {
                case 'textItem':
                    TextItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'title' => $pageItemData['title'] ?? '',
                            'body' => $pageItemData['body'] ?? '',
                            'page_id' => $page->id,
                            'sort' => $sort_counter
                        ]
                    );
                    break;
                case 'imageItem':
                    $imageItem = ImageItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter
                        ]
                    );
                    $fileIds = array_column($pageItemData['files'], 'id') ?? [];

                    if(isset($pageItemData['id'])) {
                        $imageItem->files()->sync($fileIds);
                    } else {
                        $imageItem->files()->attach($fileIds);
                    }
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported field type: {$pageItemData['type']}");
            }
            $sort_counter++;
        }
    }

}