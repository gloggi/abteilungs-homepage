<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageItem;
use App\Models\TextItem;
use App\Models\ImageItem;

class PageController extends Controller
{
    public function index(Request $request)
    {
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

    public function show($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
        $page->load('pageItems.textItem', 'pageItems.imageItem');

        return response()->json($page);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        $page = Page::create([
            'title' => $validatedData['title'],
        ]);


        foreach ($validatedData['page_items'] as $itemData) {
            $this->createPageItem($itemData, $page->id);

        }
        $page = Page::find($page->id)->load('pageItems.textItem', 'pageItems.imageItem');

        return response()->json($page, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $page = Page::find($id);
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
        Page::find($id)->update([
            'title' => $request['title'],
        ]);
        $page_items_ids = $page->pageItems->pluck('id')->toArray();
        $remaining_items_ids = [];

        foreach ($request->page_items as $page_item) {
            if (array_key_exists('id', $page_item)) {
                $remaining_items_ids[] = $page_item['id'];
                if ($page_item['type'] === 'text') {
                    TextItem::find($page_item['text_item_id'])->update([
                        'title' => $page_item['title'],
                        'body' => $page_item['body']
                    ]);
                } else if ($page_item['type'] === 'image') {
                    ImageItem::find($page_item['image_item_id'])->update([
                        'path' => $page_item['path']
                    ]);
                }
                $state = PageItem::find($page_item["page_item_id"])->update(['sort'=>$page_item['sort']]);
            error_log($state);
            } else {
                $this->createPageItem($page_item, $page->id);
            }
            
            
            

        }

        $difference = array_diff($page_items_ids, $remaining_items_ids);
        foreach ($difference as $pageItemId) {
            PageItem::find($pageItemId)->delete();
        }
        $newPage = Page::with('pageItems.textItem', 'pageItems.imageItem')->find($id);

        return response()->json($newPage);
    }

    public function destroy($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $page->delete();

        return response()->json(['message' => 'Page deleted']);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|string',
            'page_items' => 'array',
            /* 'page_items.*.type' => 'required|string',
            'page_items.*.title' => 'nullable|string',
            'page_items.*.body' => 'nullable|string',
            'page_items.*.path' => 'nullable|image|string', */
        ]);

    }

    private function createPageItem($itemData, $pageId)
    {
        $pageItem = PageItem::create([
            'type' => $itemData['type'],
            'sort' => $itemData['sort'],
            'page_id' => $pageId,
           
        ]);

        if ($itemData['type'] === 'text') {
            TextItem::create([
                'title' => isset($itemData['title']) ? $itemData['title'] : '',
                'body' => isset($itemData['body']) ? $itemData['body'] : '',
                'page_item_id' => $pageItem->id,
            ]);
        } else if ($itemData['type'] === 'image') {
            ImageItem::create([
                'path' => $itemData['path'],
                'page_item_id' => $pageItem->id,
            ]);
        }

    }
}