<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilesItem extends Model
{
    protected $fillable = ['title', 'page_id', 'sort'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return "filesItem";
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'files_item_file');

    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
