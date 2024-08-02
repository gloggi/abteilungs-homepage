<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextField extends Model
{
    protected $fillable = ['form_id', 'label', 'sort', 'input_type', 'required', 'uuid'];

    protected $appends = ['type', 'key'];

    public function getKeyAttribute()
    {
        return str_replace('-', '', $this->uuid);
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
