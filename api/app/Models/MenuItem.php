<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'page_id',
        'sort',
        'special',
        'parent_id',
    ];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'menuItem';
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort');
    }
}
