<?php

namespace App\Models;

use App\Traits\TransformTrait;
use Illuminate\Database\Eloquent\Model;



class TextField extends Model
{

    use TransformTrait;
    protected $fillable = ['form_id','label', 'sort', 'input_type', 'required'];

    protected $appends = ['type', 'key'];

    public function getKeyAttribute(){
        return $this->toCamelCase($this->label);
    }

    public function getTypeAttribute(){
        return "textField";
    }
    

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    
}

