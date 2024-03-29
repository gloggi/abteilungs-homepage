<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampRequest;
use App\Http\Requests\UpdateCampRequest;
use App\Models\Camp;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CampController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1000);
        $query = Camp::query();
        if ($request->has('group_id')) {
            $groupId = $request->input('group_id');
            $query->whereHas('groups', function ($q) use ($groupId) {
                $q->where('group_id', $groupId);
            });
        }
        $camps = $query->with(['groups', 'files'])->paginate($perPage);

        return response()->json($camps);
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
