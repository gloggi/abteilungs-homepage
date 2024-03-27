<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationItem extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'sort', 'page_id'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'locationItem';
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
