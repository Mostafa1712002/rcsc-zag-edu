<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource{

    public function toArray($request){
        return [
            'key'=>$this->id,
            'id'=>$this->id,
            'chat_id'=>$this->chat_id,
            'image'=>$this->image? url('uploads/pics/'.$this->image) : null,
            'customer1_id'=>$this->customer1_id,
            'content'=>$this->content,
            'content_short'=>Str::substr($this->content, 0, 30),
            'created_at'=>$this->created_at->format('Y-m-d H:i:s'),
            'read_at'=>$this->read_at
        ];
    }
}
