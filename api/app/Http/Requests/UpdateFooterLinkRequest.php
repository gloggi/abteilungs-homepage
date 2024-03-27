<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFooterLinkRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'url' => 'sometimes|required|url',
            'sort' => 'sometimes|required|integer',
        ];
    }
}
