<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'route' => 'nullable',
            'big_header' => 'boolean|nullable',
            'files' => 'nullable',
            'group_id' => 'nullable',
            'page_items' => 'nullable|array',
            'page_items.*.id' => 'nullable',
            'page_items.*.sort' => 'required',
            'page_items.*.type' => 'required|string|in:textItem,imageItem,formItem,filesItem,contactItem,groupsItem,sectionsItem,campItem,locationItem,faqItem,groupEventsItem',
            'page_items.*.title' => 'nullable',
            'page_items.*.body' => 'nullable',
            'page_items.*.show_fleur_de_lis' => 'nullable',
            'page_items.*.files' => 'nullable',
            'page_items.*.form_id' => 'nullable',
            'page_items.*.location_id' => 'nullable',
            'page_items.*.faq_id' => 'nullable',
            'page_items.*.group_id' => 'nullable',
        ];
    }
}
