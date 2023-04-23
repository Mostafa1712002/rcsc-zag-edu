<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource{
    public function toArray($request){
        return [
            'key'=>(int) $this->id,
            'id'=> (int) $this->id,
            'title'=>$this->{"title_".app()->getLocale()},
            'content'=>$this->{"content_".app()->getLocale()},
            'pic'=>$this->pic_url,
            'created_at'=>$this->created_at
        ];
    }
}
