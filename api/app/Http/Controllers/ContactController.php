<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $contacts = Contact::with("file")->paginate($perPage, ['*'], 'page', $page);
        $data = $contacts->items();
        $meta = [
            'current_page' => $contacts->currentPage(),
            'from' => $contacts->firstItem(),
            'last_page' => $contacts->lastPage(),
            'path' => $contacts->path(),
            'per_page' => $contacts->perPage(),
            'to' => $contacts->lastItem(),
            'total' => $contacts->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }



    public function store(Request $request)
    {
        $contact = new Contact;
        $contact->firstname = $request->input('firstname');
        $contact->lastname = $request->input('lastname');
        $contact->nickname = $request->input('nickname');
        $contact->role = $request->input('role');
        $contact->email = $request->input('email');
        $contact->file_id = $request->input('file_id') ? $request->input('file_id') : null;
        $contact->save();
        return response()->json($contact);
    }

    public function show($id)
    {
        $contact = Contact::with('file')->find($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $contact->firstname = $request->input('firstname');
        $contact->lastname = $request->input('lastname');
        $contact->nickname = $request->input('nickname');
        $contact->email = $request->input('email');
        $contact->role = $request->input('role');
        $contact->file_id = $request->input('file_id') ? $request->input('file_id') : null;
        $contact->save();
        return response()->json($contact);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return response()->json('Contact removed successfully');
    }

}