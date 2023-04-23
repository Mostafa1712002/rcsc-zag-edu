<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentBreifResource extends JsonResource{
    public function toArray($request){
        return [
            'key'=>(int) $this->id,
            'created_at'=>$this->created_at,
            'content'=>$this->getContentFor(auth('api-customers')->user()),
            'customer'=>new CustomerBreifResource($this->customer)
        ];
    }
}
