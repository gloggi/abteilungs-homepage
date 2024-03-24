<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page');
        $sections = Section::with(['file', 'files', 'groups', 'groups.file'])->orderBy('sort')
            ->paginate($perPage);

        return response()->json($sections);
    }

    public function store(StoreSectionRequest $request)
    {
        $section = Section::create($request->validated());
        $section->files()->sync(array_column($request->input('files', []), 'id'));

        return response()->json($section, 201);
    }

    public function show($id)
    {
        $section = Section::with(['file', 'files'])->find($id);

        if (!$section) {
            return response()->json(['message' => 'Section not found'], 404);
        }

        return response()->json($section);
    }

    public function update(UpdateSectionRequest $request, $id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json(['message' => 'Section not found'], 404);
        }

        $section->update($request->validated());
        $section->files()->sync(array_column($request->input('files', []), 'id'));

        return response()->json($section);
    }

    public function destroy($id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json(['message' => 'Section not found'], 404);
        }

        $section->delete();

        return response()->json(null, 204);
    }
}
