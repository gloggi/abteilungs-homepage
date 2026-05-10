<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1000);
        $query = Contact::query();
        if ($request->has('search')) {
            $searchResults = Contact::search($request->input('search'))->get();
            $query = $query->whereIn('id', $searchResults->pluck('id'));
        }

        if ($request->has('group_ids')) {
            $groupIds = $request->input('group_ids');
            if (! empty($groupIds)) {
                $query->whereHas('groups', function ($q) use ($groupIds) {
                    $q->whereIn('groups.id', $groupIds);
                });
            }
        }

        $contacts = $query->with(['file', 'groups'])->orderBy('sort', 'asc')
            ->paginate($perPage);

        return response()->json($contacts);
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        if ($request->has('groups')) {
            $contact->groups()->sync($request->input('groups'));
        }

        return response()->json($contact->load('groups'), 201);
    }

    public function show($id)
    {
        $contact = Contact::with(['file', 'groups'])->find($id);

        if (! $contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json($contact);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->update($request->validated());

        if ($request->has('groups')) {
            $contact->groups()->sync($request->input('groups'));
        }

        return response()->json($contact->load('groups'));
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();

        return response()->json(null, 204);
    }
}
