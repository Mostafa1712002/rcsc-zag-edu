<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource{
    public function toArray($request){
        $data= [
            'key'=>(int) $this->id,
            'title'=>$this->{"title_".app()->getLocale()}
        ];
        if(is_null($this->parent_id)){
            $data['sub_categories'] = CategoryResource::collection($this->children()->isActive()->get());
        }else{
            $data['admodels'] = AdmodelBreifResource::collection($this->admodels()->isActive()->get());
        }
        return $data;
    }
}
