<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;


class GroupController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $groups = Group::paginate($perPage, ['*'], 'page', $page);
        $data = $groups->items();
        $meta = [
            'current_page' => $groups->currentPage(),
            'from' => $groups->firstItem(),
            'last_page' => $groups->lastPage(),
            'path' => $groups->path(),
            'per_page' => $groups->perPage(),
            'to' => $groups->lastItem(),
            'total' => $groups->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }



    public function store(Request $request)
    {
        $group = new Group;
        $group->name = $request->input('name');
        if ($group->section_id) {
            $group->section_id = $request->input('section_id');
        }
        $group->save();
        return response()->json($group);
    }

    public function show($id)
    {
        $group = Group::find($id);
        return response()->json($group);
    }

    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        $group->name = $request->input('name');
        $group->section_id = $request->input('section_id');
        $group->save();
        return response()->json($group);
    }

    public function destroy($id)
    {
        $group = Group::find($id);
        $group->delete();
        return response()->json('Group removed successfully');
    }

}