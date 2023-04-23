<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmodelBreifResource extends JsonResource{

    public function toArray($request){
        return [
            'key'=>$this->id,
            'title'=>$this->{"title_".app()->getLocale()}
        ];
    }
}
