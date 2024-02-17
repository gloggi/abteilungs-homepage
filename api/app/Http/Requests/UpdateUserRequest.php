<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nickname' => 'sometimes|string|max:255',
            'firstname' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'role' => 'sometimes|integer|exists:roles,id',
            'groups' => 'sometimes|array',
        ];
    }
}
