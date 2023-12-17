<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'big_header' => 'boolean|nullable',
            'files' => 'nullable',
            'page_items' => 'nullable|array',
            'page_items.*.id' => 'nullable',
            'page_items.*.sort' => 'nullable',
            'page_items.*.type' => 'required|string|in:textItem,imageItem,formItem,contactItem,groupsItem,sectionsItem',
            'page_items.*.title' => 'nullable',
            'page_items.*.body' => 'nullable',
            'page_items.*.files' => 'nullable',
            'page_items.*.form_id' => 'nullable',
        ];
    }
}
