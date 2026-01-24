<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Camp extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'midata_id',
        'name',
        'description',
        'custom_description',
        'cost',
        'maximum_participants',
        'participant_count',
        'location',
        'application_opening_at',
        'application_closing_at',
        'application_conditions',
        'canton',
        'external_application_link',
        'start_date',
        'start_time',
        'finish_date',
        'finish_time',
    ];

    protected $dates = [
        'application_opening_at',
        'application_closing_at',
        'start_date',
        'finish_date',
        'created_at',
        'updated_at',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'camp_groups', 'camp_id', 'group_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'camp_files', 'camp_id', 'file_id');
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'custom_description' => $this->custom_description,
            'location' => $this->location,
            'canton' => $this->canton,
        ];
    }

    public function getStartAtAttribute()
    {
        if (! $this->start_date) {
            return null;
        }

        return \Carbon\Carbon::parse($this->start_date.' '.($this->start_time ?? '00:00:00'));
    }

    public function getFinishAtAttribute()
    {
        if (! $this->finish_date) {
            return null;
        }

        return \Carbon\Carbon::parse($this->finish_date.' '.($this->finish_time ?? '00:00:00'));
    }
}
