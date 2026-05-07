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
            'not_found_page_id' => 'nullable|integer|exists:pages,id',
            'is_region' => 'nullable|boolean',
            'social_icon_id' => 'nullable|integer|exists:files,id',
            'navbar_font_color' => 'nullable|string',
            'navbar_position' => 'nullable|in:top,between_header_and_content',
            'font_size' => 'nullable|integer',
            'side_bg_color' => 'nullable|string',
            'font_weight_heading_1' => 'nullable|integer|min:100|max:900',
            'font_weight_heading_2' => 'nullable|integer|min:100|max:900',
            'font_weight_heading_3' => 'nullable|integer|min:100|max:900',
            'raisenow_uuid' => 'nullable|string',
        ];
    }
}
