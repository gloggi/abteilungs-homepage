<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camp;
use App\Models\Setting;
use App\Http\Requests\StoreCampRequest;
use App\Http\Requests\UpdateCampRequest;
use Illuminate\Support\Facades\Http;

class CampController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $camps = Camp::paginate($perPage);

        return response()->json($camps);
    }

    public function store(StoreCampRequest $request)
    {
        $camp = Camp::create($request->validated());

        return response()->json($camp, 201);
    }

    public function show($id)
    {
        $camp = Camp::find($id);

        if (!$camp) {
            return response()->json(['message' => 'Camp not found'], 404);
        }

        return response()->json($camp);
    }

    public function update(UpdateCampRequest $request, $id)
    {
        $camp = Camp::find($id);

        if (!$camp) {
            return response()->json(['message' => 'Camp not found'], 404);
        }

        $camp->update($request->validated());

        return response()->json($camp);
    }

    public function destroy($id)
    {
        $camp = Camp::find($id);

        if (!$camp) {
            return response()->json(['message' => 'Camp not found'], 404);
        }

        $camp->delete();

        return response()->json(null, 204);
    }

}
