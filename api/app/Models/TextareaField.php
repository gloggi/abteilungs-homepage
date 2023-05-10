<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextareaField extends Model
{
    protected $fillable = ['form_id','label', 'sort'];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        return "textareaField";
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
