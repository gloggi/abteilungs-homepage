<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageItem extends Model
{
    use HasFactory;

    protected $fillable = ['file_ids', 'page_id', 'sort'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return "imageItem";
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'image_item_file');

    }

}
