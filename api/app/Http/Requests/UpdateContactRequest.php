<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'file_id' => 'nullable|integer|exists:files,id',
        ];
    }
}
