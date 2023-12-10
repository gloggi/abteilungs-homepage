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
        'primaryColor',
        'secondaryColor',
        'contact_in_footer',
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
