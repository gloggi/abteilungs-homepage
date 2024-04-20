<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Faq extends Model
{
    use Searchable;

    protected $fillable = [
        'title',
        'group_id',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
        ];
    }
}
