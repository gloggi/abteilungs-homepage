<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{


    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|required|string|max:255',
            'midata_id' => 'nullable|integer',
            'header_images' => 'array|nullable',
            'files' => 'array|nullable',
            'description' => 'nullable|string',
            'gender' => 'nullable|integer',
            'section_id' => 'required|integer|exists:sections,id',
            'file_id' => 'nullable|integer|exists:files,id',
            'parent_id' => 'nullable|integer',
            'predecessors' => 'nullable|array',
            'predecessors.*' => 'integer|exists:groups,id',
            'successors' => 'nullable|array',
            'successors.*' => 'integer|exists:groups,id',
        ];
    }
}
