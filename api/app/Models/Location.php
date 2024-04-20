<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Location extends Model
{
    use Searchable;

    protected $fillable = [
        'name', 'lat', 'long',
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'lat' => $this->lat,
            'long' => $this->long,
        ];
    }
}
