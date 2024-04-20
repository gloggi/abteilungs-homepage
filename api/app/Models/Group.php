<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Group extends Model
{
    use HasFactory, Searchable;

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
        'enable_group_page',
        'region',
        'external_link',
        'group_leader_id',
    ];

    protected $appends = ['route', 'has_page'];

    public function getRouteAttribute()
    {
        return Str::kebab($this->name);
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

    public function groupLeader()
    {
        return $this->belongsTo(User::class, 'group_leader_id');
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
