<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Invite;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
   
    public function redirectToProvider(Request $request)
    {
        $url = Socialite::driver('midata')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    public function handleProviderCallback(Request $request)
    {
        $tokenResponse = Socialite::driver('midata')->getAccessTokenResponse($request->code);
        $accessToken = $tokenResponse['access_token'];
        $midataUser = Socialite::driver('midata')->userFromToken($accessToken);

        $user = User::where('midata_id', $midataUser->id)->first();
        $setting = Setting::find(1);
        $groupIds = Group::pluck('midata_id')->toArray();
       

        if (!$user) {
            $user = User::create([
                'nickname' => $midataUser->attributes['nickname'],
                'firstname' => $midataUser->attributes['firstname'],
                'lastname' => $midataUser->attributes['lastname'],
                'email' => $midataUser->attributes['email'],
                'password' => '',
                'midata_id' => $midataUser->attributes['id']
            ]);
            if ($midata_group_ids = $this->hasRole($midataUser->user, 'Webmaster', [$setting->midata_id])) {
                $user->assignRole('admin');
            } else if ($midata_group_ids = $this->hasRole($midataUser->user, 'Abteilungsleiter*in', [$setting->midata_id])) {
                $user->assignRole('admin');
            } else if ($midata_group_ids = $this->hasRole($midataUser->user, 'Einheitsleiter*in', $groupIds)) {
                $user->assignRole('unitleader');
            }
            $groups = Group::whereIn('midata_id', $midata_group_ids)->get();
            
            $user->groups()->sync($groups);
            $user->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);


    }

    protected function hasRole($data, $roleName, $groupIds)
    {
        if (isset($data['roles']) && is_array($data['roles'])) {
            $midata_group_ids = [];
            foreach ($data['roles'] as $role) {
                if (isset($role['role_name']) && $role['role_name'] === $roleName && in_array($role['group_id'], $groupIds, true)) {
                    $midata_group_ids[] = $role['group_id'];
                }
            }
        }
        return $midata_group_ids;
    }


}
