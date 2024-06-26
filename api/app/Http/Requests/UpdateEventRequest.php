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
            'groups' => 'sometimes|required|array',
            'start_location_id' => 'nullable|integer|exists:locations,id',
            'end_location_id' => 'nullable|integer|exists:locations,id',
            'description' => 'nullable|string',
            'take_with_you' => 'nullable|string',
            'files' => 'nullable|array',
            'user_id' => 'nullable|integer|exists:users,id',
            'external_application_link' => 'nullable|string',
        ];
    }
}
