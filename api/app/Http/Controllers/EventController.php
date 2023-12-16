<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $events = Event::paginate($perPage);

        return response()->json($events);
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());

        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->update($request->validated());

        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(null, 204);
    }
}
