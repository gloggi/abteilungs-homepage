<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'section_id',
        'extension',
        'category'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
