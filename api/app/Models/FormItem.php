<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormItem extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'sort', 'page_id'];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return "formItem";
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
