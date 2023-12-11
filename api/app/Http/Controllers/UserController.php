<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $users = User::paginate($perPage, ['*'], 'page', $page);
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
        $user = User::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->nickname = $request->input('nickname');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->save();
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('User removed successfully');
    }

}