<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string',
            'questions' => 'array',
            'questions.*.question' => 'required|string',
            'questions.*.answer' => 'required|string',
            'questions.*.id' => 'nullable|integer',
            'questions.*.open' => 'nullable|boolean',
            'questions.*.sort' => 'nullable',
        ];
    }
}
