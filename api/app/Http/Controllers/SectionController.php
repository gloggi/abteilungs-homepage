<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;


class SectionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $sections = Section::with('file')->paginate($perPage, ['*'], 'page', $page);
        $data = $sections->items();
        $meta = [
            'current_page' => $sections->currentPage(),
            'from' => $sections->firstItem(),
            'last_page' => $sections->lastPage(),
            'path' => $sections->path(),
            'per_page' => $sections->perPage(),
            'to' => $sections->lastItem(),
            'total' => $sections->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }



    public function store(Request $request)
    {
        $section = new Section;
        $section->name = $request->input('name');
        $section->from_age = $request->input('from_age');
        $section->to_age = $request->input('to_age');
        $section->file_id = $request->input('file_id');
        $section->description = $request->input('description');
        $section->save();
        return response()->json($section);
    }

    public function show($id)
    {
        $section = Section::with('file')->find($id);
        return response()->json($section);
    }

    public function update(Request $request, $id)
    {
        $section = Section::find($id);
        $section->name = $request->input('name');
        $section->from_age = $request->input('from_age');
        $section->to_age = $request->input('to_age');
        $section->file_id = $request->input('file_id');
        $section->description = $request->input('description');
        $section->save();
        return response()->json($section);
    }

    public function destroy($id)
    {
        $section = Section::find($id);
        $section->delete();
        return response()->json('Section removed successfully');
    }

}