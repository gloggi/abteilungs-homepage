<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    use HasFactory;


    protected $fillable = [
        'midata_id',
        'name',
        'description',
        'cost',
        'maximum_participants',
        'participant_count',
        'location',
        'application_opening_at',
        'application_closing_at',
        'application_conditions',
        'canton',
        'external_application_link',
        'start_at',
        'finish_at'
    ];

    protected $dates = [
        'application_opening_at',
        'application_closing_at',
        'start_at',
        'finish_at',
        'created_at',
        'updated_at'
    ];
}
