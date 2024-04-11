<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TextField extends Model
{
    protected $fillable = ['form_id', 'label', 'sort', 'input_type', 'required'];

    protected $appends = ['type', 'key'];

    public function getKeyAttribute()
    {
        return Str::camel($this->label);
    }

    public function getTypeAttribute()
    {
        return 'textField';
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
