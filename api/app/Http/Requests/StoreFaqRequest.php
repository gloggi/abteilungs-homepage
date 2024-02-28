<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaqRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|unique:faqs,title',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.answer' => 'required|string',
            'questions.*.id' => 'nullable|integer',
            'questions.*.open' => 'nullable|boolean',
            'questions.*.sort' => 'required',
        ];
    }
}
