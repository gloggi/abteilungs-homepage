<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Mail\EventInfo;
use App\Models\Event;
use App\Models\Group;
use App\Models\Location;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1000);
        $groupId = $request->input('group_id');
        $currentDateTime = now();
        $user = Auth::user();

        $query = Event::with(['startLocation', 'endLocation', 'groups', 'files', 'user']);
        if ($request->has('search')) {
            $searchResults = Event::search($request->input('search'))->get();
            $query = $query->whereIn('id', $searchResults->pluck('id'));
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
        $events = $query->get();

        $upcomingEvents = $events->filter(function ($event) use ($currentDateTime) {
            return $event->start_time >= $currentDateTime;
        })->sortBy('start_time');

        $pastEvents = $events->reject(function ($event) use ($currentDateTime) {
            return $event->start_time >= $currentDateTime;
        })->sortByDesc('start_time');

        if ($request->has('dashboard') && $user) {
            $sortedEvents = $upcomingEvents->merge($pastEvents);
        } else {
            $sortedEvents = $upcomingEvents->merge([]);
        }

        $paginatedEvents = new LengthAwarePaginator(
            $sortedEvents->forPage($request->page, $perPage)->values(),
            $sortedEvents->count(),
            $perPage,
            $request->page
        );

        return response()->json($paginatedEvents);
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $event = Event::create($validated);
        if (! array_key_exists('user_id', $validated)) {
            $event->user_id = Auth::user()->id;
            $event->save();
        }
        $event->groups()->sync($request->input('groups', []));
        $event->files()->sync(array_column($request->input('files', []), 'id'));

        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = Event::with(['groups', 'files', 'user'])->find($id);

        if (! $event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::find($id);

        if (! $event) {
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

        if (! $event) {
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
        $midataIds = $user->groups->pluck('midata_id');
        foreach ($midataIds as $midataId) {
            $midataBaseUrl = config('services.midata.base_url');
            $response = Http::get("{$midataBaseUrl}/de/groups/{$midataId}/events/simple.json?token={$token}");
            $externalEvents = $response->json();
            if (! array_key_exists('linked', $externalEvents)) {
                continue;
            }
            $eventDatesMap = collect($externalEvents['linked']['event_dates'])->keyBy('id');

            foreach ($externalEvents['events'] as $externalEvent) {
                $eventDateIds = $externalEvent['links']['dates'] ?? [];
                $eventDate = collect($eventDateIds)->map(fn ($id) => $eventDatesMap->get($id))->first();
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
                        'end_time' => $eventDate['finish_at'] ? Carbon::parse($eventDate['finish_at']) : null,
                        'user_id' => $user->id,
                    ]
                );
                $group = Group::where('midata_id', $midataId)->first();
                $event->groups()->sync([$group->id]);
            }

            $event->save();

        }

        return response()->json(['message' => 'External events synced successfully']);
    }

    public function getMail($id)
    {
        $event = Event::with(['groups', 'files', 'user', 'startLocation', 'endLocation'])->find($id);

        if (! $event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        $subject = 'Infos '.$event->title;
        $from = $event->user->firstname.' '.$event->user->lastname.($event->user->nickname ? (' v/o '.$event->user->nickname) : '');
        $bbc = $event->user->email;
        $content = $this->getMailText($event);

        return response()->json([
            'subject' => $subject,
            'from' => $from,
            'content' => $content,
            'bcc' => $bbc,
        ]);
    }

    private function getMailText($event)
    {
        $date = Carbon::parse($event->start_time)->format('d.m.Y H:i').' - '.Carbon::parse($event->end_time)->format('H:i');
        $name = $event->user->nickname ? $event->user->nickname : ($event->user->firstname.' '.$event->user->lastname);
        $location = $event->startLocation->name;
        $mailText = "<p class='main-text'>Hallo zusammen</p><p class='main-text'>
        {$event->description}
        <br>
        <strong>Datum und Zeit</strong>: 
        {$date}
        <br>
        <strong>Besammlung</strong>: 
        {$event->startLocation->name}
        <br>
        <strong>Schluss</strong>: 
        {$event->endLocation->name}
        <br><br><strong>Mitnehmen</strong>:<br>
        {$event->take_with_you}
        <br>
        Bei Fragen kannst Du dich gerne bei mir melden.
        <br>
        <br>
        Liebe Grüsse<br>
        {$name}
        </p>";

        return $mailText;
    }

    public function sendMail(Request $request, $id)
    {
        $event = Event::with(['groups', 'files', 'user', 'startLocation', 'endLocation'])->find($id);

        if (! $event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $subject = $request->input('subject');
        $from = $request->input('from');
        $content = $request->input('content');
        $bcc = $request->input('bcc');
        $fromName = $request->input('from');
        $replyToMail = $event->user->email;

        $toMails = $request->input('receiver');
        $setting = Setting::find(1);
        preg_match_all('/[a-z0-9_\-\+\.]+@[a-z0-9\-\.]+\.[a-z]{2,}/i', $toMails, $matches);
        $emails = $matches[0];

        $validatedEmails = array_filter($emails, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        if (empty($validatedEmails)) {
            return response()->json(['message' => 'Du hast keine gültigen E-Mail-Adressen eingegeben.'], 400);
        }

        foreach ($validatedEmails as $email) {
            Mail::to($email)->send(new EventInfo($subject, $content, $fromName, $replyToMail, $setting));
        }

        return response()->json(['message' => 'Mail sent!'], 201);
    }
}
