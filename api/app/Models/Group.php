<?php

namespace App\Models;

use App\Traits\TransformTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, TransformTrait;

    protected $fillable = [
        'name',
        'section_id',
        'extension',
        'category',
        'file_id',
        'color',
        'gender',
        'parent_id',
        'midata_id',
        'description',
        'enable_group_page',
        'region',
        'external_link',
    ];

    protected $appends = ['route','has_page'];

    public function getRouteAttribute()
    {
        return $this->toCamelCase($this->name);
    }

    public function getHasPageAttribute()
    {
        return $this->page ? true : false;
    }




    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function parent()
    {
        return $this->belongsTo(Group::class);
    }

    public function predecessors()
    {
        return $this->belongsToMany(Group::class, 'group_predecessor', 'group_id', 'predecessor_id');
    }

    public function successors()
    {
        return $this->belongsToMany(Group::class, 'group_successor', 'group_id', 'successor_id');
    }

    public function page()
    {
        return $this->hasOne(Page::class);
    }
}
