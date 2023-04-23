<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request){
        return [
            'key'=>(int) $this->id,
            'created_at'=>$this->created_at,
            'customer'=>new CustomerBreifResource($this->customer),
            'ad'=> new AdResource($this->ad),
            'action_type'=>$this->type
        ];
    }
}
