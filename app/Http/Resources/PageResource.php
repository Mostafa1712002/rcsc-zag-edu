<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource{
    public function toArray($request){
        $content = app()->getLocale() == 'ar' ? str_replace('text-align: left;','text-align: right;',$this->content_ar) : $this->content_en;
        $content = str_replace('src="//www.','src="https://www.',$content);
        return [
            'key'=>$this->id,
            'title'=>$this->{"title_".app()->getLocale()},
            'content'=>$content
        ];
    }
}
