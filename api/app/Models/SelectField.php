<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectField extends Model
{
    protected $fillable = ['form_id','label', 'sort'];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        return "selectField";
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
