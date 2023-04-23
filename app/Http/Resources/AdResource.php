<?php

namespace App\Http\Resources;

use App\Models\Ad;
use App\Models\Page;
use App\Http\Resources\RegionBreifResource;
use App\Http\Resources\AdmodelBreifResource;
use App\Http\Resources\CategoryBreifResource;
use App\Http\Resources\DepartmentBreifResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource{
    public function toArray($request){
        $pics = $this->pics;

        if($this->pics)
        {
            foreach($pics as $k=>$pic)
            {
                $pics[$k] = url('uploads/pics/'.$pic);
            }
        }

        $like_type = null;
        $is_following = false;
        $is_favorited = false;
        $is_visited = null;
        if($customer=auth('api-customers')->user()){
            $like = $customer->likes()->whereAdId($this->id)->first();
            $like_type = $like? $like->type : null;
            $is_following = $customer->isFollowing($this->id,'ad');
            $is_visited = $this->customerVisited($customer->id);

            $is_favorited = $customer->favorites()->whereAdId($this->id)->exists();
        }

        $likes = $this->likes;
        $likes_count = $likes->where('type','like')->count();
        $dislikes_count = $likes->where('type','dislike')->count();


        $this->status = $this->deleted_at? 'deleted' : $this->status;

        $data= [
            'key'=>$this->id,
            'title'=>$this->title_ar ,
            'sharing_link'=>route('show_ad',$this->id),
            'factory_year'=>$this->factory_year,
            'is_favrotied'=>$is_favorited,
            'deleted_at'=>$this->deleted_at,
            'is_following'=>$is_following,
            'is_visited'=>$is_visited,
            'like_type'=>$like_type,
            'status'=>__('site.'.$this->status),
            'status_key'=>$this->status,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'image'=>$this->image_url,
            'pics'=>$pics,
            'is_double'=>$this->is_double,
            'gear_type'=>__('site.'.$this->gear_type),
            'gear_type_key'=>$this->gear_type,
            'fuel_type'=>__('site.'.$this->fuel_type),
            'fuel_type_key'=>$this->fuel_type,
            'is_guaranteed'=>$this->is_guaranteed,
            'likes'=>$likes_count,
            'dislikes'=>$dislikes_count,
            'followers_count'=>(int) $this->followers_count,

            'content'=>$this->content_ar,
            'car_agency'=>$this->cars_agency,
            'department'=> new DepartmentBreifResource($this->department),
            'region'=> new RegionBreifResource($this->region),
            'city'=> new CityResource($this->city),
            'ad_type'=>__('site.'.$this->ad_type),
            'ad_type_key'=>$this->ad_type,
            'parent_category'=> new CategoryBreifResource($this->parentCategory),
            'sub_category'=> new CategoryBreifResource($this->subCategory),
            'admodel'=> new AdmodelBreifResource($this->admodel),
            'price'=>$this->price,
            'ad_status'=>$this->ad_status,
            'set_price'=>is_null($this->price)? 0 : 1,
            'allow_comments'=>$this->allow_comments,
            'show_mobile'=>$this->show_mobile,
            'mobile_number'=>is_null($this->mobile_number)? $this->customer->mobile : $this->mobile_number,
            'customer'=> new CustomerBreifResource($this->customer),
            'views'=>(int) $this->views_count,
            'district'=> $this->district,

            'commission'=>$this->{"commission_".app()->getLocale()}
        ];


        return $data;
    }
}
