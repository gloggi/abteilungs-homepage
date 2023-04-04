<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextItem extends Model
{
    protected $fillable = ['title', 'body', 'page_item_id'];
    
    public function pageItem()
    {
        return $this->belongsTo(PageItem::class);
    }
}