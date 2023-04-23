<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdBreifResource extends JsonResource
{

    public function toArray($request){
        $this->status = $this->deleted_at? 'deleted' : $this->status;
        return [
            'key'=>$this->id,
            'status'=>__('site.'.$this->status),
            'status_key'=>$this->status,
            'title'=>$this->{"title_".app()->getLocale()},
            'sharing_link'=>route('show_ad',$this->id),
            'content'=>$this->{"content_".app()->getLocale()},
            'image'=>$this->image_url,
            'ad_type'=>__('site.'.$this->ad_type),
            'created_at'=>$this->created_at,

        ];
    }
}
