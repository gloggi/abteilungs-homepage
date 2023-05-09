<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'section_id',
        'extension',
        'category',
        'file_id'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function predecessors()
    {
        return $this->belongsToMany(Group::class, 'group_predecessor', 'group_id', 'predecessor_id');
    }

    public function successors()
    {
        return $this->belongsToMany(Group::class, 'group_successor', 'group_id', 'successor_id');
    }
}