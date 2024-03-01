<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    protected $fillable = ['title', 'route', 'file_ids', 'big_header', 'group_id'];

    protected $hidden = ['textItems', 'imageItems', 'formItems', 'filesItems', 'genericItems'];

    public function files()
    {
        return $this->belongsToMany(File::class, 'page_file');

    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function textItems()
    {

        return $this->hasMany(TextItem::class);
    }

    public function imageItems()
    {

        return $this->hasMany(ImageItem::class)->with('files');
    }

    public function formItems()
    {

        return $this->hasMany(FormItem::class)->with('form')->without('form.email');
    }

    public function formItemsWithFields()
    {
        $formItems = $this->formItems()->get();

        foreach ($formItems as $formItem) {
            if ($form = $formItem->form) {
                $form->fields = $form->getAllFields();
            }
        }

        return $formItems;
    }

    public function filesItems()
    {

        return $this->hasMany(FilesItem::class)->with('files');
    }

    public function locationItems()
    {

        return $this->hasMany(LocationItem::class)->with('location');
    }
    public function faqItems()
    {

        return $this->hasMany(FaqItem::class)->with('faq')->with('faq.questions');
    }

    public function groupEventsItems()
    {

        return $this->hasMany(GroupEventsItem::class)->with('group');
    }

    public function genericItems()
    {

        return $this->hasMany(GenericItem::class);
    }

    public function getAllItems()
    {
        $items = collect([]);

        $textItems = $this->textItems;
        $imageItems = $this->imageItems;
        $formItems = $this->formItems;
        $filesItems = $this->filesItems;
        $genericItems = $this->genericItems;
        $locationItems = $this->locationItems;
        $faqItems = $this->faqItems;
        $groupEventsItems = $this->groupEventsItems;

        $items = $items->concat($textItems);
        $items = $items->concat($imageItems);
        $items = $items->concat($formItems);
        $items = $items->concat($filesItems);
        $items = $items->concat($genericItems);
        $items = $items->concat($locationItems);
        $items = $items->concat($faqItems);
        $items = $items->concat($groupEventsItems);

        $items = $items->sortBy('sort')->values()->all();;

        return $items;
    }
}
