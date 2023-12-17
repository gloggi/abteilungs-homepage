<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'string|max:255|required',
            'route' => 'string|max:255|unique:pages|nullable',
            'big_header' => 'boolean|nullable',
            'files' => 'array|nullable',
            'page_items' => 'nullable|array',
            'page_items.*.id' => 'nullable',
            'page_items.*.sort' => 'nullable',
            'page_items.*.type' => 'required|string|in:textItem,imageItem,formItem,contactItem,groupsItem,sectionsItem',
            'page_items.*.title' => 'nullable',
            'page_items.*.body' => 'nullable',
            'page_items.*.file_id' => 'nullable'
        ];
    }
}
