<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageItem extends Model
{
    protected $fillable = ['type', 'page_id'];
    
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
    
    public function textItem()
    {
        return $this->hasOne(TextItem::class);
    }
    
    public function imageItem()
    {
        return $this->hasOne(ImageItem::class);
    }
    public function toArray()
    {
        $array = parent::toArray();
        unset($array["page_id"]);
        foreach ($array as $key => $value) {
            if (is_null($value)) {
                unset($array[$key]);
            }
            else if(is_array($value)){
               
                unset($array[$key]["page_item_id"]);
                foreach ($value as $subKey => $subValue) {
                    if($subKey=="id"){
                        $array[$key."_".$subKey] = $subValue;
                    }else{
                    $array[$subKey] = $subValue;
                }
                }
                unset($array[$key]);

            }
            
        }
            
        return $array;
    }
    
}