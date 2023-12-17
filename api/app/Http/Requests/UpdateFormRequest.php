<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|max:255',
            'subject' => 'sometimes|string|max:255',
            'fields' => 'nullable|array',
            'fields.*.input_type' => 'nullable',
            'fields.*.id' => '',
            'fields.*.sort' => 'nullable',
            'fields.*.required' => 'nullable',
            'fields.*.type' => 'required|string|in:textField,textareaField,selectField',
            'fields.*.option_fields' => 'nullable|array|min:1',
            'fields.*.label' => 'nullable|string|max:255',
        ];
    }
}
