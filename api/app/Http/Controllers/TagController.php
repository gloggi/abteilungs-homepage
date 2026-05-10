<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('dashboard')) {
            return response()->json(Tag::paginate(20));
        }

        return response()->json(Tag::all());
    }

    public function show($id)
    {
        return response()->json(Tag::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'color' => 'nullable|string|max:7',
        ]);

        $tag = Tag::create($validatedData);

        return response()->json($tag, 201);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,'.$tag->id,
            'color' => 'nullable|string|max:7',
        ]);

        $tag->update($validatedData);

        return response()->json($tag);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return response()->json(null, 204);
    }
}
