<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;


class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $events = Event::paginate($perPage, ['*'], 'page', $page);
        $data = $events->items();
        $meta = [
            'current_page' => $events->currentPage(),
            'from' => $events->firstItem(),
            'last_page' => $events->lastPage(),
            'path' => $events->path(),
            'per_page' => $events->perPage(),
            'to' => $events->lastItem(),
            'total' => $events->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }



    public function store(Request $request)
    {
        $event = new Event;
        $event->title = $request->input('title');
        $event->start_time = $request->input('start_time');
        $event->end_time = $request->input('end_time');
        $event->group_id = $request->input('group_id');
        $event->start_location_id = $request->input('start_location_id');
        $event->end_location_id = $request->input('end_location_id');
        $event->description = $request->input('description');
        $event->save();
        return response()->json($event);
    }

    public function show($id)
    {
        $event = Event::find($id);
        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $event->title = $request->input('title');
        $event->start_time = $request->input('start_time');
        $event->end_time = $request->input('end_time');
        $event->group_id = $request->input('group_id');
        $event->start_location_id = $request->input('start_location_id');
        $event->end_location_id = $request->input('end_location_id');
        $event->description = $request->input('description');
        $event->save();
        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return response()->json('Event removed successfully');
    }

}