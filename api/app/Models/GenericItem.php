<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenericItem extends Model
{
    protected $fillable = ['type', 'page_id', 'sort'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
