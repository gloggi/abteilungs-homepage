<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;

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
        $setting = Setting::with(['divisionLogo', 'websiteIcon'])->find(1);
        return response()->json($setting);
    }
}
