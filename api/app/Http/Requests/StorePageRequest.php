<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    protected $restrictedKeywords = ['login', 'dashboard', 'token', 'gruppen'];

    public function rules()
    {
        return [
            'title' => 'string|max:255|required',
            'route' => [
                'nullable',
                'string',
                'max:255',
                'unique:pages',
                function ($attribute, $value, $fail) {
                    if (in_array($value, $this->restrictedKeywords)) {
                        $fail('Der Permalink ist reserviert und kann nicht verwendet werden.');
                    }
                },
            ],
            'big_header' => 'boolean|nullable',
            'files' => 'array|nullable',
            'group_id' => 'nullable|unique:pages,group_id',
            'password' => 'nullable|string',
            'page_items' => 'nullable|array',
            'page_items.*.id' => 'nullable',
            'page_items.*.sort' => 'required',
            'page_items.*.type' => 'required|string|in:textItem,imageItem,formItem,filesItem,contactItem,groupsItem,sectionsItem,campItem,locationItem,faqItem,groupEventsItem',
            'page_items.*.title' => 'nullable',
            'page_items.*.body' => 'nullable',
            'page_items.*.section_id' => 'nullable',
            'page_items.*.files' => 'nullable',
            'page_items.*.file_id' => 'nullable',
            'page_items.*.form_id' => 'nullable',
            'page_items.*.location_id' => 'nullable',
            'page_items.*.faq_id' => 'nullable',
            'page_items.*.group_id' => 'nullable',
        ];
    }
}
