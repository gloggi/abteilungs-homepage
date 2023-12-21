<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{

    protected $fillable = [
        'title','start_time', 'end_time', 'start_location_id', 'end_location_id', 'description', 'take_with_you'
    ];


    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getStartTimeAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }

    public function getEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'event_groups', 'event_id', 'group_id');
    }

    public function startLocation()
    {
        return $this->belongsTo(Location::class, 'start_location_id');
    }

  
    public function endLocation()
    {
        return $this->belongsTo(Location::class, 'end_location_id');
    }
}
