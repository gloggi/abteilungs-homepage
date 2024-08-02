<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionField extends Model
{
    protected $fillable = ['select_field_id', 'name', 'sort', 'uuid'];

    public function selectField()
    {
        return $this->belongsTo(SelectField::class);
    }
}
