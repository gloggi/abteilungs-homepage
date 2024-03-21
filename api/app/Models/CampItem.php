<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampItem extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'sort', 'page_id'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return "campItem";
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
