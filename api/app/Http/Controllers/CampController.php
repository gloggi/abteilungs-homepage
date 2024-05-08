<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampRequest;
use App\Http\Requests\UpdateCampRequest;
use App\Models\Camp;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CampController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1000);
        $groupId = $request->input('group_id');
        $currentDateTime = now();
        $user = Auth::user();

        $query = Camp::with(['groups', 'files']);

        if ($request->has('search')) {
            $searchResults = Camp::search($request->input('search'))->get();
            $query->whereIn('id', $searchResults->pluck('id'));
        }

        if ($groupId) {
            $query->whereHas('groups', function ($query) use ($groupId) {
                $query->where('groups.id', $groupId);
            });
        }

        if ($request->has('dashboard') && $user->hasRole('unitleader')) {
            $query->whereHas('groups', function ($query) use ($user) {
                $query->whereIn('groups.id', $user->groups->pluck('id'));
            });
        }

        $camps = $query->get();

        $upcomingCamps = $camps->filter(function ($camp) use ($currentDateTime) {
            return $camp->finish_at > $currentDateTime;
        })->sortBy('finish_at');

        $pastCamps = $camps->reject(function ($camp) use ($currentDateTime) {
            return $camp->finish_at > $currentDateTime;
        })->sortByDesc('finish_at');

        if ($request->has('dashboard') && $user) {
            $sortedCamps = $upcomingCamps->merge($pastCamps);
        } else {
            $sortedCamps = $upcomingCamps;
        }

        $paginatedCamps = new LengthAwarePaginator(
            $sortedCamps->forPage($request->page, $perPage)->values(),
            $sortedCamps->count(),
            $perPage,
            $request->page
        );

        return response()->json($paginatedCamps);
    }

    public function store(StoreCampRequest $request)
    {
        $camp = Camp::create($request->validated());
        $camp->files()->sync(array_column($request->input('files', []), 'id'));
        $camp->groups()->sync($request->input('groups', []));

        return response()->json($camp, 201);
    }

    public function show($id)
    {
        $camp = Camp::with(['groups', 'files'])->find($id);

        if (! $camp) {
            return response()->json(['message' => 'Camp not found'], 404);
        }

        return response()->json($camp);
    }

    public function update(UpdateCampRequest $request, $id)
    {
        $camp = Camp::find($id);

        if (! $camp) {
            return response()->json(['message' => 'Camp not found'], 404);
        }

        $camp->update($request->validated());
        $camp->files()->sync(array_column($request->input('files', []), 'id'));
        $camp->groups()->sync($request->input('groups', []));

        return response()->json($camp);
    }

    public function destroy($id)
    {
        $camp = Camp::find($id);

        if (! $camp) {
            return response()->json(['message' => 'Camp not found'], 404);
        }

        $camp->delete();

        return response()->json(null, 204);
    }

    public function syncExternalCamps()
    {
        $setting = Setting::find(1);
        $token = $setting->midata_api_key;
        if (! $token) {
            return response()->json(['message' => 'MiData API key not found'], 404);
        }
        $midataId = $setting->midata_id;
        $midataBaseUrl = config('services.midata.base_url');
        $response = Http::get("{$midataBaseUrl}/de/groups/{$midataId}/events/camp.json?token={$token}");
        $externalCamps = $response->json();

        $eventDatesMap = collect($externalCamps['linked']['event_dates'])->keyBy('id');

        foreach ($externalCamps['events'] as $externalCamp) {
            $eventDateIds = $externalCamp['links']['dates'] ?? [];
            $eventDate = collect($eventDateIds)->map(fn ($id) => $eventDatesMap->get($id))->first();

            $cost = $externalCamp['cost'];
            $numericCost = preg_replace('/[^0-9.]+/', '', $cost);
            $floatCost = $cost === '' ? null : floatval($numericCost);
            Camp::updateOrCreate(
                ['midata_id' => $externalCamp['id']],
                [
                    'name' => $externalCamp['name'],
                    'description' => $externalCamp['description'],
                    'cost' => $floatCost,
                    'maximum_participants' => $externalCamp['maximum_participants'],
                    'participant_count' => $externalCamp['participant_count'],
                    'location' => $externalCamp['location'],
                    'application_opening_at' => $externalCamp['application_opening_at'],
                    'application_closing_at' => $externalCamp['application_closing_at'],
                    'application_conditions' => $externalCamp['application_conditions'],
                    'external_application_link' => $externalCamp['external_application_link'],
                    'start_at' => $eventDate['start_at'] ? Carbon::parse($eventDate['start_at']) : null,
                    'finish_at' => $eventDate['finish_at'] ? Carbon::parse($eventDate['finish_at']) : null,
                ]
            );
        }

        return response()->json(['message' => 'External camps synced successfully']);
    }
}
