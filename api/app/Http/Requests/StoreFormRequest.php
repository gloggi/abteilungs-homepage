<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'group_id' => 'nullable|integer',
            'enable_autoresponse' => 'nullable|boolean',
            'autoresponse_subject' => 'nullable|string|max:255',
            'autoresponse_message' => 'nullable|string',
            'autoresponse_email_field_id' => 'nullable|exists:text_fields,id',
            'fields' => 'nullable|array',
            'fields.*.type' => 'required|string|in:textField,textareaField,selectField',
            'fields.*.input_type' => 'nullable',
            'fields.*.required' => 'nullable',
            'fields.*.sort' => 'required',
            'fields.*.option_fields' => 'nullable|array|min:1',
            'fields.*.label' => 'required|string|max:255',
        ];
    }
}
