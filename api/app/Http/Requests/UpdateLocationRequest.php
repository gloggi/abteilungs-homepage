<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id');
        return [
            'name' => 'sometimes|required|string|max:255|unique:locations,name,' . $id,
            'lat' => 'sometimes|required|numeric',
            'long' => 'sometimes|required|numeric',
        ];
    }
}
