<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{

    public function toArray($request){
        $is_following = false;
        if($customer=auth('api-customers')->user()){
            $is_following = $customer->isFollowing($this->id,'customer');
        }

        $resource = [
            'key'=>(int) $this->id,
            'sharing_link'=>route('show_customer',$this->id),
            'is_following'=>$is_following,
            'email'=>$this->email,
            'avatar'=>$this->avatar_url,
            'followers_count'=>$this->followers_count,
            'full_name'=>$this->first_name,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'account_verified_at'=>$this->email_verified_at,
            'status'=>$this->status,
            'mobile'=>$this->mobile,
            'full_mobile_number'=>$this->mobile_full_number,
            // 'verification_code'=>$this->verification_code,
            'device_id'=>$this->device_id,
            'country_code'=>$this->country_code,
            'rating'=>$this->avg_rating

        ];
        return $resource;
    }
}
