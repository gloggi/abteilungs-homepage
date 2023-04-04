<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageItem extends Model
{
    use HasFactory;

    protected $fillable = ['file_id', 'page_item_id'];

    public function pageItem()
    {
        return $this->belongsTo(PageItem::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
