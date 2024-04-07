<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255|unique:forms,name,'.$id,
            'email' => 'sometimes|string|max:255',
            'subject' => 'sometimes|string|max:255',
            'group_id' => 'nullable|integer',
            'enable_autoresponse' => 'nullable|boolean',
            'autoresponse_subject' => 'nullable|string|max:255',
            'autoresponse_message' => 'nullable|string',
            'autoresponse_email_field_id' => 'nullable|exists:text_fields,id',
            'fields' => 'nullable|array',
            'fields.*.input_type' => 'nullable',
            'fields.*.id' => 'sometimes|integer',
            'fields.*.sort' => 'sometimes|required',
            'fields.*.required' => 'nullable',
            'fields.*.type' => 'sometimes|required|string|in:textField,textareaField,selectField',
            'fields.*.option_fields' => 'nullable|array|min:1',
            'fields.*.label' => 'sometimes|required|string|max:255',
        ];
    }
}
