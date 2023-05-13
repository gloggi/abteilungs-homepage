<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageItem extends Model
{
    use HasFactory;

    protected $fillable = ['file_id', 'page_id'];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        return "imageItem";
    }
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
