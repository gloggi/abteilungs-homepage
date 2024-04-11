<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TextareaField extends Model
{
    protected $fillable = ['form_id', 'label', 'sort', 'required'];

    protected $appends = ['type', 'key'];

    public function getKeyAttribute()
    {
        return Str::camel($this->label);
    }

    public function getTypeAttribute()
    {
        return 'textareaField';
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
