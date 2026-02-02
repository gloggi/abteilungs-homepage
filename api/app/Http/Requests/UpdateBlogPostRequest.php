<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogPostRequest extends FormRequest
{
    protected $restrictedKeywords = ['login', 'dashboard', 'token', 'gruppen', 'blog'];

    public function rules()
    {
        $id = $this->route('id');

        return [
            'title' => 'sometimes|required|string|max:255',
            'slug' => [
                'nullable',
                Rule::unique('blog_posts')->ignore($id),
                function ($attribute, $value, $fail) {
                    if (in_array($value, $this->restrictedKeywords)) {
                        $fail('Der Permalink ist reserviert und kann nicht verwendet werden.');
                    }
                },
            ],
            'published_at' => 'nullable|date',
            'active' => 'boolean',
            'user_id' => 'nullable|exists:users,id',
            'preview_image_id' => 'nullable|exists:files,id',
            'files' => 'array|nullable',
            'page_items' => 'nullable|array',
            'page_items.*.id' => 'nullable',
            'page_items.*.sort' => 'required',
            'page_items.*.type' => 'required|string|in:textItem,imageItem,formItem,filesItem,contactItem,groupsItem,sectionsItem,campItem,locationItem,faqItem,groupEventsItem,blogPostsItem',
            'page_items.*.title' => 'nullable',
            'page_items.*.body' => 'nullable',
            'page_items.*.section_id' => 'nullable',
            'page_items.*.files' => 'nullable',
            'page_items.*.file_id' => 'nullable',
            'page_items.*.form_id' => 'nullable',
            'page_items.*.location_id' => 'nullable',
            'page_items.*.faq_id' => 'nullable',
            'page_items.*.group_id' => 'nullable',
            'page_items.*.view_mode' => 'nullable|string',
            'page_items.*.blog_posts' => 'nullable|array',
        ];
    }
}
