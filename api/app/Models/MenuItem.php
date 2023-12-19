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
        'special'
    ];
    protected $appends = ['type'];

    public function getTypeAttribute(){
        return "menuItem";
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

}