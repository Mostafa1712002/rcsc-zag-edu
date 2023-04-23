<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryBreifResource extends JsonResource{

    public function toArray($request)    {
        return [
            'key'=>(int) $this->id,
            'title'=>$this->{"title_".app()->getLocale()}
        ];
    }
}
