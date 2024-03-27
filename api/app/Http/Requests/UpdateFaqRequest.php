<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id');

        return [
            'title' => 'sometimes|required|string|unique:faqs,title,'.$id,
            'questions' => 'array',
            'group_id' => 'nullable|integer',
            'questions.*.question' => 'sometimes|required|string',
            'questions.*.answer' => 'sometimes|required|string',
            'questions.*.id' => 'nullable|integer',
            'questions.*.open' => 'nullable|boolean',
            'questions.*.sort' => 'nullable',
        ];
    }
}
