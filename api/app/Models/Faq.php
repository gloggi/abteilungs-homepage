<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
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
}
