<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'gender' => 'nullable|integer',
            'section_id' => 'nullable|integer|exists:sections,id',
            'file_id' => 'nullable|integer|exists:files,id',
            'predecessors' => 'nullable|array',
            'predecessors.*' => 'integer|exists:groups,id',
            'successors' => 'nullable|array',
            'successors.*' => 'integer|exists:groups,id',
        ];
    }
}
