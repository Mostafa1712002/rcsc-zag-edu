<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerBreifResource extends JsonResource{

    public function toArray($request){
        $is_following = false;
        if($customer=auth('api-customers')->user()){
            $is_following = $customer->isFollowing($this->id,'customer');
        }
        $resource = [
            'key'=>(int) $this->id,
            'id'=>$this->id,
            'status'=>$this->status,
            'sharing_link'=>route('show_customer',$this->id),
            'is_following'=>$is_following,
            'rating'=>$this->avg_rating,
            'name'=>$this->full_name,
            'email'=>$this->email,
            'avatar'=>$this->avatar_url,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'mobile'=>$this->mobile_full_number,
            'created_at'=>$this->created_at
        ];
        return $resource;
    }
}
