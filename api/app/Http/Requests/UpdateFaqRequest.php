<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|unique:faqs,title',
            'questions' => 'array',
            'questions.*.question' => 'sometimes|required|string',
            'questions.*.answer' => 'sometimes|required|string',
            'questions.*.id' => 'nullable|integer',
            'questions.*.open' => 'nullable|boolean',
            'questions.*.sort' => 'nullable',
        ];
    }
}
