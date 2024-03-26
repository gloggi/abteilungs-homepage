<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function update(UpdateSettingRequest $request)
    {
        $setting = Setting::firstOrNew(['id' => 1]);
        $setting->fill($request->validated())->save();
        return response()->json($setting);
    }

    public function show()
    {
        $setting = Setting::with(['divisionLogo', 'websiteIcon', 'socialIcon', 'notFoundPage'])->find(1);
        if(!Auth::user()||!Auth::user()->hasRole('admin')) {
            
            $setting = $setting->makeHidden(['midata_id', 'midata_api_key' ]);
        }
        return response()->json($setting);
    }
}
