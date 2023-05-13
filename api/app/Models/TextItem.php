<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextItem extends Model
{
    protected $fillable = ['title', 'body', 'page_id'];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        return "textItem";
    }
    
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}