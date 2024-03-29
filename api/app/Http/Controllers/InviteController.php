<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function invite(Request $request)
    {
        do {
            $token = Str::random(16);
        } while (Invite::where('token', $token)->first());

        $invite = Invite::create([
            'email' => $request->get('email'),
            'token' => $token,
        ]);
        //Mail::to($request->get('email'))->send(new InviteCreated($invite));
    }
}
