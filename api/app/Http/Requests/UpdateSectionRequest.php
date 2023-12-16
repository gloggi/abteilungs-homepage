<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|required|string|max:255',
            'from_age' => 'nullable|integer',
            'to_age' => 'nullable|integer',
            'file_id' => 'nullable|integer|exists:files,id',
            'description' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'integer|exists:files,id',
        ];
    }
}
