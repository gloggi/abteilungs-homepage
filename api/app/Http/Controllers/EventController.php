<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $groupId = $request->input('group_id');
        $currentDateTime = now();

        $query = Event::with(['startLocation', 'endLocation', 'groups']);
        if ($groupId) {
            $query->whereHas('groups', function ($query) use ($groupId) {
                $query->where('groups.id', $groupId);
            });
        }
        if($request->has('dashboard')){
            $user = Auth::user();
            $userMidataId = $user->midata_group_id;
            $query->whereHas('groups', function ($query) use ($userMidataId) {
                $query->where('groups.midata_id', $userMidataId);
            });
        }
        $events = $query->get();

        $upcomingEvents = $events->filter(function ($event) use ($currentDateTime) {
            return $event->start_time >= $currentDateTime;
        })->sortBy('start_time');

        $pastEvents = $events->reject(function ($event) use ($currentDateTime) {
            return $event->start_time >= $currentDateTime;
        })->sortByDesc('start_time');

        $sortedEvents = $upcomingEvents->merge($pastEvents);
        $paginatedEvents = new LengthAwarePaginator(
            $sortedEvents->forPage($request->page, $perPage),
            $sortedEvents->count(),
            $perPage,
            $request->page
        );

        return response()->json($paginatedEvents);
    }


    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());
        $event->groups()->sync($request->input('groups', []));

        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = Event::with('groups')->find($id);

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
        $event->groups()->sync($request->input('groups', []));

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
