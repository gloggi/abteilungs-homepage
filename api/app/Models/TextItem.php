<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextItem extends Model
{
    protected $fillable = ['title', 'body', 'page_id', 'sort', 'section_id', 'group_id'];

    protected $appends = ['type', 'logoCircle'];

    public function getTypeAttribute()
    {
        return 'textItem';
    }

    public function getLogoCircleAttribute()
    {
        if ($this->group&&$this->group->file) {

            return [
                'path' => $this->group->file->path,
                'color' => $this->group->color,
            ];
        }
        if ($this->section&&$this->section->file) {
            return [
                'path' => $this->section->file->path,
            ];
        }

        return null;
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
