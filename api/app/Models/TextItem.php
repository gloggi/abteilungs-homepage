<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextItem extends Model
{
    protected $fillable = ['title', 'body', 'show_fleur_de_lis', 'page_id', 'sort'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'textItem';
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
