<?php

namespace App\Models;

use App\Traits\TransformTrait;
use Illuminate\Database\Eloquent\Model;

class SelectField extends Model
{
    use TransformTrait;

    protected $fillable = ['form_id', 'label', 'sort', 'required'];

    protected $appends = ['type', 'key'];

    public function getKeyAttribute()
    {
        return $this->toCamelCase($this->label);
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
