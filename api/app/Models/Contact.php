<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Contact extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['firstname', 'lastname', 'nickname', 'email', 'file_id', 'role', 'sort'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function toSearchableArray()
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'nickname' => $this->nickname,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
