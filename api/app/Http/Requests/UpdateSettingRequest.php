<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'site_title' => 'required|string',
            'division_name' => 'required|string',
            'midata_id' => 'nullable|integer',
            'midata_api_key' => 'nullable|string',
            'midata_parent_id' => 'nullable|integer',
            'division_logo_id' => 'nullable|integer|exists:files,id',
            'website_icon_id' => 'nullable|integer|exists:files,id',
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'contact_in_footer' => 'nullable|string',
        ];
    }
}
