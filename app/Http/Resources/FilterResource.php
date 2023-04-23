<?php

namespace App\Http\Resources;

use App\Http\Requests\CarsAgenciesRequset;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'key'=>(int) $this->id,
            'created_at'=>$this->created_at,
            'followers_count'=>(int) $this->followers_count,
            'department'=>new DepartmentResource($this->department),
            'parent_category'=> new CategoryResource($this->parentCategory),
            'sub_category'=> new CategoryResource($this->subCategory),
            'admodel'=> new AdmodelResource($this->admodel),
            'city'=> new CityResource($this->city),
            'district'=> $this->district,
            'ad_status'=> $this->ad_status,
            'car_agency' =>  new CarAgencyResource($this->carAgency),
        ];
    }
}
