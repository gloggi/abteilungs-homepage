<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'file_id' => 'nullable|integer|exists:files,id',
        ];
    }
}
