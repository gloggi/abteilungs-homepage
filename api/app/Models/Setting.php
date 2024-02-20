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
    ];


    public function divisionLogo()
    {
        return $this->belongsTo(File::class, 'division_logo_id');
    }

    public function websiteIcon()
    {
        return $this->belongsTo(File::class, 'website_icon_id');
    }
}
