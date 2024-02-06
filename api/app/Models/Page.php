<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    protected $fillable = ['title', 'route', 'file_ids', 'big_header'];

    public function files()
    {
        return $this->belongsToMany(File::class, 'page_file');

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

        return $this->hasMany(FormItem::class)->with('form');
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

        $items = $items->concat($textItems);
        $items = $items->concat($imageItems);
        $items = $items->concat($formItems);
        $items = $items->concat($filesItems);
        $items = $items->concat($genericItems);

        $items = $items->sortBy('sort')->values()->all();;

        return $items;
    }
}
