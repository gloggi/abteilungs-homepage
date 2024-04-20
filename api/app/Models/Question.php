<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use Searchable;

    protected $fillable = [
        'question', 'answer', 'sort', 'faq_id', 'open',
    ];

    public function toSearchableArray()
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}
