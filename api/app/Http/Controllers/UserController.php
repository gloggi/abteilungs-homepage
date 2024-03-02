<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $users = User::with('roles')->paginate($perPage, ['*'], 'page', $page);
        $data = $users->items();
        $meta = [
            'current_page' => $users->currentPage(),
            'from' => $users->firstItem(),
            'last_page' => $users->lastPage(),
            'path' => $users->path(),
            'per_page' => $users->perPage(),
            'to' => $users->lastItem(),
            'total' => $users->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->nickname = $request->input('nickname');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->save();
        return response()->json($user);
    }

    public function show($id)
    {
        $user = User::with('roles')->with('groups')->find($id);
        if($user->hasRole('admin')){
            $user->role = 1;
        }else if($user->hasRole('unitleader')){
            $user->role = 2;
        }
        return response()->json($user);
    }

    public function getUserInfo(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
            ], 404);
        }
        $user->load('roles');
        $user->load('groups');

        return response()->json($user, 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $validated = $request->validated();
        $user->update($validated);
        $user->roles()->detach();
        if($request['role']==1){
            $user->assignRole('admin');
        }else if($request['role']==2){
            $user->assignRole('unitleader');
        }
        $user->save();
        $user->groups()->sync($validated['groups']);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('User removed successfully');
    }

}
