<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OptionField extends Model
{
    use HasUuids;

    protected $fillable = ['select_field_id', 'name', 'sort', 'uuid'];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function selectField()
    {
        return $this->belongsTo(SelectField::class);
    }
}
