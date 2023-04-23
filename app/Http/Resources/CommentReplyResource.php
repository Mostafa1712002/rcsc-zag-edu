<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentReplyResource extends JsonResource{

    public function toArray($request){
        return [
            'key'=> (int) $this->id,
            'content'=>$this->content,
            'customer'=>new CustomerBreifResource($this->customer)
        ];
    }
}
