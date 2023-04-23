<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarAgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'key'=>(int) $this->id,
            'name_ar'=> $this->name_ar,
            'name_en'=> $this->name_en,
            'name'=> $this->name,
            'image'=> $this->image_url,
            'created_at'=>$this->created_at,
        ];
    }
}
