<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;


class MenuitemController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 100);
        $page = $request->input('page', 1);
        $menuItems = MenuItem::with("page")->paginate($perPage, ['*'], 'page', $page);
        
        $data = $menuItems->items();
        $data = collect($data)->sortBy('sort')->values()->all();
        foreach ($data as $item) {
            if ($item->page) {
                $item->url = "/". $item->page->route;
                $item->title = $item->page->title;
                unset($item->page);
            }
        }
        $meta = [
            'current_page' => $menuItems->currentPage(),
            'from' => $menuItems->firstItem(),
            'last_page' => $menuItems->lastPage(),
            'path' => $menuItems->path(),
            'per_page' => $menuItems->perPage(),
            'to' => $menuItems->lastItem(),
            'total' => $menuItems->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
        }



        public function store(Request $request)
        {
            $existingMenuItemOfPage = MenuItem::where('page_id', $request->input('page_id'))->first();
            $existingMenuItemOfCustom = MenuItem::where('url', $request->input('url'))->first();
            if ($existingMenuItemOfPage&& $request->input('page_id')) {
                $existingMenuItemOfPage->sort = $request->input('sort');
                $existingMenuItemOfPage->save();
                return response()->json($existingMenuItemOfPage);
            }
            if ($existingMenuItemOfCustom&& $request->input('url')) {
                $existingMenuItemOfCustom->sort = $request->input('sort');
                $existingMenuItemOfCustom->save();
                return response()->json($existingMenuItemOfCustom);
            }
            $menuItem = new MenuItem;
            $menuItem->title = $request->input('title')?? null;
            $menuItem->url = $request->input('url')?? null;
            $menuItem->sort = $request->input('sort');
            $menuItem->page_id = $request->input('page_id')?? null;
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
