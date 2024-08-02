<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextareaField extends Model
{
    protected $fillable = ['form_id', 'label', 'sort', 'required', 'uuid'];

    protected $appends = ['type', 'key'];

    public function getKeyAttribute()
    {
        return str_replace('-', '', $this->uuid);
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
