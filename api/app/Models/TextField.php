<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextField extends Model
{
    protected $fillable = ['form_id','label', 'sort', 'input_type'];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        return "textField";
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    
}

