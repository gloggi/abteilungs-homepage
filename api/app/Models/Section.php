<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Section extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'description', 'from_age', 'to_age', 'file_id', 'file_ids', 'color', 'sort'];

    public function files()
    {
        return $this->belongsToMany(File::class, 'section_file');

    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
