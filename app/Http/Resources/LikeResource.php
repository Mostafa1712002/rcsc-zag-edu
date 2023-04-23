<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){
        return [
            'key'=>(int) $this->id,
            'created_at'=>$this->created_at,
            'customer'=>new CustomerResource($this->customer),
            'ad'=> new AdResource($this->ad),
            'action_type'=>$this->type
        ];
    }
}
