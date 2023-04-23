<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowResource extends JsonResource{

    public function toArray($request){
        $subject_resource_class_name = "App\Http\Resources\\".ucfirst($this->type)."Resource";
        $subject = new $subject_resource_class_name($this->followable);
        return [
            'key'=>(int) $this->id,
            'created_at'=>$this->created_at,
            'subject'=> $subject
        ];
    }
}
