<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date',
            'group_id' => 'sometimes|required|integer|exists:groups,id',
            'start_location_id' => 'sometimes|required|integer|exists:locations,id',
            'end_location_id' => 'sometimes|required|integer|exists:locations,id',
            'description' => 'nullable|string',
        ];
    }
}
