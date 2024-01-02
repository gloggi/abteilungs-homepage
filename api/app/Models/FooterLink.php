<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    protected $fillable = ['title', 'url', 'sort'];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        return "footerLink";
    }

   
}