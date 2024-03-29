<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:locations,name',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ];
    }
}
