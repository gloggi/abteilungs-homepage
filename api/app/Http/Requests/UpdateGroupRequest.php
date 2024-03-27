<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255|unique:groups,name,'.$id,
            'color' => 'sometimes|required|string|max:255',
            'midata_id' => 'nullable|integer',
            'region' => 'nullable|string|max:255',
            'gender' => 'sometimes|required|integer',
            'section_id' => 'sometimes|required|integer|exists:sections,id',
            'file_id' => 'nullable|integer|exists:files,id',
            'parent_id' => 'nullable|integer',
            'predecessors' => 'nullable|array',
            'predecessors.*' => 'integer|exists:groups,id',
            'successors' => 'nullable|array',
            'successors.*' => 'integer|exists:groups,id',
            'enable_group_page' => 'boolean',
            'external_link' => 'nullable|string|max:255',
            'group_leader_id' => 'nullable|integer|exists:users,id',
        ];
    }
}
