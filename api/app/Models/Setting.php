<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_title',
        'division_name',
        'division_logo_id',
        'website_icon_id',
        'primary_color',
        'secondary_color',
        'contact_in_footer',
        'midata_id',
        'midata_api_key',
        'alert_text',
        'alert_bg_color',
        'alert_text_color',
        'show_alert',
        'alert_url',
        'not_found_page_id',
        'is_region',
        'social_icon_id',
    ];

    public function divisionLogo()
    {
        return $this->belongsTo(File::class, 'division_logo_id');
    }

    public function websiteIcon()
    {
        return $this->belongsTo(File::class, 'website_icon_id');
    }

    public function socialIcon()
    {
        return $this->belongsTo(File::class, 'social_icon_id');
    }

    public function notFoundPage()
    {
        return $this->belongsTo(Page::class, 'not_found_page_id');
    }
}
