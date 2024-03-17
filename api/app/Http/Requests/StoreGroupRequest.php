<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:groups,name',
            'color' => 'required|string|max:255',
            'midata_id' => 'nullable|integer',
            'region' => 'nullable|string|max:255',
            'gender' => 'required|integer',
            'section_id' => 'required|integer|exists:sections,id',
            'file_id' => 'nullable|integer|exists:files,id',
            'parent_id' => 'nullable|integer',
            'predecessors' => 'nullable|array',
            'predecessors.*' => 'integer|exists:groups,id',
            'successors' => 'nullable|array',
            'successors.*' => 'integer|exists:groups,id',
            'enable_group_page' => 'nullable|boolean',
            'external_link' => 'nullable|string|max:255',
        ];
    }
}
