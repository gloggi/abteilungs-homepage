<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'from_age' => 'required|integer',
            'to_age' => 'required|integer',
            'file_id' => 'nullable|integer|exists:files,id',
            'description' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'integer|exists:files,id',
        ];
    }
}
