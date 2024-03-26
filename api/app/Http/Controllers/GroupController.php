<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $groups = $groups = Group::select('groups.*')
        ->with(['file', 'section', 'predecessors', 'successors', 'parent', 'groupLeader'])
        ->leftJoin('sections', 'groups.section_id', '=', 'sections.id')
        ->orderBy('sections.sort', 'asc');
        if ($request->has('dashboard') && $user->hasRole('unitleader')) {
            $groups = $groups->whereIn('id', $user->groups->pluck('id'));
        }
        
        $perPage = $request->input('per_page', 1000);
       
        $groups = $groups->paginate($perPage);

        return response()->json($groups);
    }

    public function store(StoreGroupRequest $request)
    {
        $group = Group::create($request->validated());

        $group->predecessors()->sync($request->input('predecessors', []));
        $group->successors()->sync($request->input('successors', []));

        return response()->json($group, 201);
    }

    public function show($idOrRoute)
    {
        $query = Group::with(['section', 'file', 'predecessors', 'successors', 'parent', 'page', 'page.files']);
        if (is_numeric($idOrRoute)) {
            $group = $query->find($idOrRoute);
        } else {
            $groups = $query->get();
            $filteredGroups = $groups->filter(function ($group) use ($idOrRoute) {
                return $group->route == $idOrRoute;
            });

            $group = $filteredGroups->first();
        }
        if($group->page){
            $group->page->page_items = $group->page->getAllItems();
            
            $pageItems = $group->page->page_items;

            foreach ($pageItems as $currentField) {
                if ($currentField->type == 'formItem' && $currentField->form) {
                    unset($currentField->form->email);
                    $currentField->form->fields = $currentField->form->getAllFields();
                }
            }
        }

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
        $user = Auth::user();
        if ($user->hasRole('unitleader') && !$user->groups->contains($group)) {
            return response()->json(['message' => 'You are not allowed to update this group'], 403);
        }

        $group->update($request->validated());

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
