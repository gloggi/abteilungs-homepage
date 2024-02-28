<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255|unique:sections,name',
            'color' => 'sometimes|required|string|max:255',
            'from_age' => 'sometimes|required|integer',
            'to_age' => 'sometimes|required|integer',
            'file_id' => 'nullable|integer|exists:files,id',
            'description' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'nullable',
        ];
    }
}
