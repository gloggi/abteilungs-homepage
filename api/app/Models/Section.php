<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'from_age', 'to_age', 'file_id'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
