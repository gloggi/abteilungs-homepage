<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'custom_description' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'maximum_participants' => 'nullable|integer',
            'participant_count' => 'required|integer',
            'location' => 'nullable|string|max:255',
            'application_opening_at' => 'nullable|date',
            'application_closing_at' => 'nullable|date',
            'application_conditions' => 'nullable|string',
            'canton' => 'nullable|string|max:255',
            'external_application_link' => 'required|string|max:255',
            'start_at' => 'nullable|date',
            'finish_at' => 'nullable|date',
            'files' => 'nullable|array',
            'groups' => 'nullable|array',
        ];
    }
}
