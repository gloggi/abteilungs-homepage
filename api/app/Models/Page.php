<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    protected $fillable = ['title', 'route'];
    
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
        $genericItems = $this->genericItems;

        $items = $items->concat($textItems);
        $items = $items->concat($imageItems);
        $items = $items->concat($formItems);
        $items = $items->concat($genericItems);

        $items = $items->sortBy('sort')->values()->all();;

        return $items;
    }
}
