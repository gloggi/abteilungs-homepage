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
        $contacts = $query->with('file')->orderBy('sort', 'asc')
            ->paginate($perPage);

        return response()->json($contacts);
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        return response()->json($contact, 201);
    }

    public function show($id)
    {
        $contact = Contact::with('file')->find($id);

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

        return response()->json($contact);
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
