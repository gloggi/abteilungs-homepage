<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page');
       
        $locations = Location::paginate($perPage);

        return response()->json($locations);
    }

    public function store(StoreLocationRequest $request)
    {
        $location = Location::create($request->validated());

        return response()->json($location, 201);
    }

    public function show($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        return response()->json($location);
    }

    public function update(UpdateLocationRequest $request, $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $location->update($request->validated());

        return response()->json($location);
    }

    public function destroy($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $location->delete();

        return response()->json(null, 204);
    }
}
