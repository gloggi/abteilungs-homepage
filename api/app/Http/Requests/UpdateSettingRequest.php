<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'site_title' => 'sometimes|required|string',
            'division_name' => 'sometimes|required|string',
            'midata_id' => 'nullable|integer',
            'midata_api_key' => 'nullable|string',
            'division_logo_id' => 'nullable|integer|exists:files,id',
            'website_icon_id' => 'nullable|integer|exists:files,id',
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'contact_in_footer' => 'nullable|string',
            'alert_text' => 'nullable|string',
            'alert_bg_color' => 'nullable|string',
            'alert_text_color' => 'nullable|string',
            'show_alert' => 'nullable|boolean',
            'alert_url' => 'nullable|string',
            'not_found_page_id' => 'nullable|integer|exists:pages,id'
        ];
    }
}
