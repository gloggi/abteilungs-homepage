<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TextField extends Model
{
    use HasUuids;

    protected $fillable = ['form_id', 'label', 'sort', 'input_type', 'required', 'uuid'];

    protected $appends = ['type'];

    public function uniqueIds(): array
    {
        return ['uuid'];
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
