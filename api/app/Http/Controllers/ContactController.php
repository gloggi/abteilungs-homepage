<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with('file')
                           ->paginate($request->input('per_page', 10));

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

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json($contact);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->update($request->validated());

        return response()->json($contact);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();

        return response()->json(null, 204);
    }
}
