<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SelectField extends Model
{
    use HasUuids;

    protected $fillable = ['form_id', 'label', 'sort', 'required', 'uuid'];

    protected $appends = ['type'];

    public function uniqueIds(): array
    {
        return ['uuid'];
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
