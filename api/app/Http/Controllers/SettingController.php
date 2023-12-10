<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;


class SettingController extends Controller
{
    public function update(Request $request)
    {
        $setting = Setting::firstOrNew(['id' => 1]);
        $setting->site_title = $request->input('site_title');
        $setting->division_name = $request->input('division_name');
        $setting->division_logo_id = $request->input('division_logo_id');
        $setting->website_icon_id = $request->input('website_icon_id');
        $setting->primary_color = $request->input('primary_color');
        $setting->secondary_color = $request->input('secondary_color');
        $setting->contact_in_footer = $request->input('contact_in_footer');
        $setting->save();
        return response()->json($setting);
    }
    public function show()
    {
        $setting = Setting::with('divisionLogo', 'websiteIcon')->find(1);
        if (!$setting) {
            $setting = new Setting();
            $setting->site_title = "Default Site Title";
            $setting->division_name = "Default Division Name";
            $setting->save();
        }
        return response()->json($setting);
    }
}