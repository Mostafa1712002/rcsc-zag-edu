<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'key'=>$this->id,
            'title'=>$this->{"title_".app()->getLocale()},
            'parent_categories'=> CategoryResource::collection($this->parentCategories()->isActive()->get()),
        ];
    }
}
