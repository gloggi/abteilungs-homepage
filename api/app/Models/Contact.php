<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['firstname', 'lastname', 'nickname', 'email', 'file_id', 'role', 'sort'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
