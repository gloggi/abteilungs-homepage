<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;


class LocationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $locations = Location::paginate($perPage, ['*'], 'page', $page);
        $data = $locations->items();
        $meta = [
            'current_page' => $locations->currentPage(),
            'from' => $locations->firstItem(),
            'last_page' => $locations->lastPage(),
            'path' => $locations->path(),
            'per_page' => $locations->perPage(),
            'to' => $locations->lastItem(),
            'total' => $locations->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }



    public function store(Request $request)
    {
        $location = new Location;
        $location->name = $request->input('name');
        $location->lat = $request->input('lat');
        $location->long = $request->input('long');
        $location->save();
        return response()->json($location);
    }

    public function show($id)
    {
        $location = Location::find($id);
        return response()->json($location);
    }

    public function update(Request $request, $id)
    {
        $location = Location::find($id);
        $location->name = $request->input('name');
        $location->lat = $request->input('lat');
        $location->long = $request->input('long');
        $location->save();
        return response()->json($location);
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        $location->delete();
        return response()->json('Location removed successfully');
    }

}