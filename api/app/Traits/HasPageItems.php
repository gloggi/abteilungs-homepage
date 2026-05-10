<?php

namespace App\Traits;

use App\Models\CampItem;
use App\Models\ContactItem;
use App\Models\FaqItem;
use App\Models\FilesItem;
use App\Models\FormItem;
use App\Models\GenericItem;
use App\Models\GroupEventsItem;
use App\Models\ImageItem;
use App\Models\LocationItem;
use App\Models\TextItem;

trait HasPageItems
{
    abstract public function getItemForeignKey();

    public function textItems()
    {
        return $this->hasMany(TextItem::class, $this->getItemForeignKey());
    }

    public function imageItems()
    {
        return $this->hasMany(ImageItem::class, $this->getItemForeignKey())->with('files');
    }

    public function formItems()
    {
        return $this->hasMany(FormItem::class, $this->getItemForeignKey())->with('form')->without('form.email');
    }

    public function formItemsWithFields()
    {
        $formItems = $this->formItems()->get();

        foreach ($formItems as $formItem) {
            if ($form = $formItem->form) {
                $form->fields = $form->getAllFields();
                unset($form->email);
            }
        }

        return $formItems;
    }

    public function filesItems()
    {
        return $this->hasMany(FilesItem::class, $this->getItemForeignKey())->with('files');
    }

    public function locationItems()
    {
        return $this->hasMany(LocationItem::class, $this->getItemForeignKey())->with('location');
    }

    public function faqItems()
    {
        return $this->hasMany(FaqItem::class, $this->getItemForeignKey())
            ->with(['faq' => function ($query) {
                $query->with(['questions' => function ($query) {
                    $query->orderBy('sort', 'asc');
                }]);
            }]);
    }

    public function groupEventsItems()
    {
        return $this->hasMany(GroupEventsItem::class, $this->getItemForeignKey())->with('group');
    }

    public function campItems()
    {
        return $this->hasMany(CampItem::class, $this->getItemForeignKey());
    }

    public function genericItems()
    {
        return $this->hasMany(GenericItem::class, $this->getItemForeignKey());
    }

    public function contactItems()
    {
        return $this->hasMany(ContactItem::class, $this->getItemForeignKey());
    }

    public function blogPostsItems()
    {
        return $this->hasMany(\App\Models\BlogPostsItem::class, $this->getItemForeignKey())->with('blogPosts', 'tags');
    }

    public function getAllItems()
    {
        $items = collect([]);

        $items = $items->concat($this->textItems);
        $items = $items->concat($this->imageItems);
        $items = $items->concat($this->formItemsWithFields());
        $items = $items->concat($this->filesItems);
        $items = $items->concat($this->genericItems);
        $items = $items->concat($this->locationItems);
        $items = $items->concat($this->faqItems);
        $items = $items->concat($this->groupEventsItems);
        $items = $items->concat($this->campItems);
        $items = $items->concat($this->contactItems);
        $items = $items->concat($this->blogPostsItems);

        $items = $items->sortBy('sort')->values()->all();

        return $items;
    }
}
