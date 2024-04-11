<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SelectField extends Model
{
    protected $fillable = ['form_id', 'label', 'sort', 'required'];

    protected $appends = ['type', 'key'];

    public function getKeyAttribute()
    {
        return Str::camel($this->label);
    }

    public function getTypeAttribute()
    {
        return 'selectField';
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function optionFields()
    {
        return $this->hasMany(OptionField::class);
    }
}
