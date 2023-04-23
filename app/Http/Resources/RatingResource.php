<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){
        $subject_resource_class_name = "App\Http\Resources\\".ucfirst($this->type)."Resource";
        $subject = new $subject_resource_class_name($this->ratingable);
        return [
            'key'=>(int) $this->id,
            'class'=>$subject_resource_class_name,
            'created_at'=>$this->created_at,
            'value'=>(int) $this->rating_value,
            'type'=>$this->type,
            'subject'=>$subject
        ];
    }
}
