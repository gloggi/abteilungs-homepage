<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id');
        return [
            'name' => 'sometimes|string|max:255|unique:forms,name,' . $id,
            'email' => 'sometimes|string|max:255',
            'subject' => 'sometimes|string|max:255',
            'group_id' => 'sometimes|integer',
            'fields' => 'nullable|array',
            'fields.*.input_type' => 'nullable',
            'fields.*.id' => 'integer',
            'fields.*.sort' => 'sometimes|required',
            'fields.*.required' => 'nullable',
            'fields.*.type' => 'sometimes|required|string|in:textField,textareaField,selectField',
            'fields.*.option_fields' => 'nullable|array|min:1',
            'fields.*.label' => 'sometimes|required|string|max:255',
        ];
    }
}
