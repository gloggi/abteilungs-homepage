<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'group_id' => 'required|integer|exists:groups,id',
            'start_location_id' => 'nullable|integer|exists:locations,id',
            'end_location_id' => 'nullable|integer|exists:locations,id',
            'description' => 'nullable|string',
        ];
    }
}
