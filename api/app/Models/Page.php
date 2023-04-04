<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    protected $fillable = ['title', 'route'];
    
    public function pageItems()
    {

        return $this->hasMany(PageItem::class);
    }
}
