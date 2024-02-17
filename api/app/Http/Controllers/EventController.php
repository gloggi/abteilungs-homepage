<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\Location;
use App\Models\Group;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $groupId = $request->input('group_id');
        $currentDateTime = now();

        $query = Event::with(['startLocation', 'endLocation', 'groups', 'files']);
        if ($groupId) {
            $query->whereHas('groups', function($query) use ($groupId) {
                $query->where('groups.id', $groupId);
            });
        }
        if ($request->has('dashboard')) {
            $user = Auth::user();
            $userMidataId = $user->midata_group_id;
            $query->whereHas('groups', function($query) use ($userMidataId) {
                $query->where('groups.midata_id', $userMidataId);
            });
        }
        $events = $query->get();

        $upcomingEvents = $events->filter(function($event) use ($currentDateTime) {
            return $event->start_time >= $currentDateTime;
        })->sortBy('start_time');

        $pastEvents = $events->reject(function($event) use ($currentDateTime) {
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
        $event->files()->sync(array_column($request->input('files', []), 'id'));

        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = Event::with('groups')->with('files')->find($id);

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
        $event->files()->sync(array_column($request->input('files', []), 'id'));

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

    public function syncExternalEvents()
    {
        $setting = Setting::find(1);
        $token = $setting->midata_api_key;
        $user = Auth::user();
        $midataId = $user->midata_group_id;
        $midataBaseUrl = env('MIDATA_BASE_URL', 'https://pbs.puzzle.ch');
        $response = Http::get("{$midataBaseUrl}/de/groups/{$midataId}/events/simple.json?token={$token}");
        $externalEvents = $response->json();

        $eventDatesMap = collect($externalEvents['linked']['event_dates'])->keyBy('id');

        foreach ($externalEvents['events'] as $externalEvent) {
            $eventDateIds = $externalEvent['links']['dates'] ?? [];
            $eventDate = collect($eventDateIds)->map(fn($id) => $eventDatesMap->get($id))->first();
            $locationId = Location::firstWhere('name', $eventDate['location'])->id ?? null;
            $event = Event::updateOrCreate(
                ['midata_id' => $externalEvent['id']],
                [
                    'title' => $externalEvent['name'],
                    'description' => $externalEvent['description'],
                    'start_location_id' => $locationId,
                    'end_location_id' => $locationId,
                    'external_application_link' => $externalEvent['external_application_link'],
                    
                    'start_time' => $eventDate['start_at'] ? Carbon::parse($eventDate['start_at']) : null,
                    'end_time' => $eventDate['finish_at'] ? Carbon::parse($eventDate['finish_at']) : null
                ]
            );
            $group = Group::where('midata_id', $midataId)->first();
            $event->groups()->sync([$group->id]);
           
            
           $event->save();

        }

        return response()->json(['message' => 'External events synced successfully']);
    }
}
