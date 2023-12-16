<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'lat' => 'sometimes|required|numeric',
            'long' => 'sometimes|required|numeric',
        ];
    }
}
