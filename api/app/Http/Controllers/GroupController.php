<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $groups = Group::with(['file', 'section','predecessors', 'successors', 'parent', 'headerImages'])
                       ->paginate($perPage);

        return response()->json($groups);
    }

    public function store(StoreGroupRequest $request)
    {
        $group = Group::create($request->validated());
        $group->headerImages()->sync(array_column($request->input('header_images', []), 'id'));
        
        $group->predecessors()->sync($request->input('predecessors', []));
        $group->successors()->sync($request->input('successors', []));

        return response()->json($group, 201);
    }

    public function show($id)
    {
        $group = Group::with(['section', 'file', 'predecessors', 'successors', 'parent','headerImages'])
                      ->find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        return response()->json($group);
    }

    public function update(UpdateGroupRequest $request, $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->update($request->validated());
        $group->headerImages()->sync(array_column($request->input('header_images', []), 'id'));

        $group->predecessors()->sync($request->input('predecessors', []));
        $group->successors()->sync($request->input('successors', []));

        return response()->json($group);
    }

    public function destroy($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->delete();

        return response()->json(null, 204);
    }
}
