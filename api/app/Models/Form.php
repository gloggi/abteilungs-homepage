<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'group_id'];

    public function textFields()
    {
        return $this->hasMany(TextField::class);
    }

    public function textareaFields()
    {
        return $this->hasMany(TextareaField::class);
    }

    public function selectFields()
    {
        return $this->hasMany(SelectField::class)->with('optionFields');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function getAllFields()
    {
        $fields = collect([]);

        $textFields = $this->textFields;
        $textareaFields = $this->textareaFields;
        $selectFields = $this->selectFields;

        $fields = $fields->concat($textFields);
        $fields = $fields->concat($textareaFields);
        $fields = $fields->concat($selectFields);

        $fields = $fields->sortBy('sort')->values()->all();;

        return $fields;
    }
}
