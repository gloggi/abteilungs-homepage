<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'maximum_participants' => 'nullable|integer',
            'participant_count' => 'sometimes|required|integer',
            'location' => 'nullable|string|max:255',
            'application_opening_at' => 'nullable|date',
            'application_closing_at' => 'nullable|date',
            'application_conditions' => 'nullable|string',
            'canton' => 'nullable|string|max:255',
            'external_application_link' => 'sometimes|required|string|max:255',
            'start_at' => 'nullable|date',
            'finish_at' => 'nullable|date',
        ];
    }
}
