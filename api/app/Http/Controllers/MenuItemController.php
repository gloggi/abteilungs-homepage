<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $menuItems = MenuItem::whereNull('parent_id')
            ->with(['page', 'children.page', 'children.children.page'])
            ->orderBy('sort')
            ->get();

        $data = $this->transformMenuItems($menuItems);

        return response()->json([
            'data' => $data,
        ]);
    }

    private function transformMenuItems($items)
    {
        return $items->map(function ($item) {
            if ($item->page) {
                $item->url = '/'.$item->page->route;
                $item->title = $item->page->title;
                // Keep page for ID reference if needed, but original code unset it.
                // keeping it is useful for "Edit" in admin.
                // $item->page is hidden by unset in original, but we might want it.
                // Let's stick to original behavior but we need 'id' for dragging.
                unset($item->page);
            }

            if ($item->children && $item->children->count() > 0) {
                $item->children = $this->transformMenuItems($item->children);
            }

            return $item;
        });
    }

    public function store(Request $request)
    {
        // Logic to update existing based on specific constraints
        // Using ID is safer for updates if provided.
        if ($request->has('id')) {
            $menuItem = MenuItem::find($request->input('id'));
            if ($menuItem) {
                $menuItem->title = $request->input('title'); // Allow title updates
                $menuItem->url = $request->input('url');
                $menuItem->special = $request->input('special');
                $menuItem->sort = $request->input('sort');
                $menuItem->page_id = $request->input('page_id');
                $menuItem->parent_id = $request->input('parent_id');
                $menuItem->save();

                return response()->json($menuItem);
            }
        }

        // Fallback to legacy check or create new
        // For drag and drop reordering, we often send the whole object with ID.
        // If we want to support the old "add by page_id" logic:

        $menuItem = new MenuItem;
        $menuItem->title = $request->input('title');
        $menuItem->url = $request->input('url');
        $menuItem->special = $request->input('special');
        $menuItem->sort = $request->input('sort');
        $menuItem->page_id = $request->input('page_id');
        $menuItem->parent_id = $request->input('parent_id');
        $menuItem->save();

        return response()->json($menuItem);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);
        $menuItem->delete();

        return response()->json('MenuItem removed successfully');
    }
}
