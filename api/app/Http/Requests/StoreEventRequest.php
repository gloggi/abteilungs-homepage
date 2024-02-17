<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'take_with_you' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'groups' => 'nullable|array',
            'start_location_id' => 'required|integer|exists:locations,id',
            'end_location_id' => 'nullable|integer|exists:locations,id',
            'files' => 'nullable|array',
        ];
    }
}
