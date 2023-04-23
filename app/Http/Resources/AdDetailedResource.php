<?php

namespace App\Http\Resources;

use App\Models\Ad;
use App\Http\Resources\RegionBreifResource;
use App\Http\Resources\AdmodelBreifResource;
use App\Http\Resources\CategoryBreifResource;
use App\Http\Resources\DepartmentBreifResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdDetailedResource extends JsonResource{
    public function toArray($request){
        $pics = $this->pics;
        foreach($pics as $k=>$pic){
            $pics[$k] = url('uploads/pics/'.$pic);
        }

        $like_type = null;
        $is_following = false;
        $is_favorited = false;
        $is_visited = null;
        if($customer=auth('api-customers')->user()){
            $like = $customer->likes()->whereAdId($this->id)->first();
            $like_type = ($like)? $like->type : null;
            $is_following = $customer->isFollowing($this->id,'ad');
            $is_visited = $this->customerVisited($customer->id);

            $is_favorited = $customer->favorites()->whereAdId($this->id)->exists();
        }

        $data= [
            'key'=>$this->id,
            'comments'=>CommentBreifResource::collection($this->comments()->orderByDesc('id')->take(5)->get()),
            'similar_ads'=>AdBreifResource::collection(Ad::isActive()->where(function($query){
                    return $query->orWhere($this->only(['department_id','parent_category_id','sub_category_id','admodel_id','city_id']));
            })->where('id','!=',$this->id)->orderByDesc('updated_at')->take(15)->get()),
            'is_favrotied'=>$is_favorited,
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
            'likes'=>$this->likes()->whereType('like')->count(),
            'dislikes'=>$this->likes()->whereType('dislike')->count(),
            'followers_count'=>(int) $this->followers_count,
            'title'=>$this->{"title_".app()->getLocale()} ,
            'title_ar'=>$this->title_ar,
            'title_en'=>$this->title_en,
            'content'=>$this->{"content_".app()->getLocale()},
            'content_ar'=>$this->content_ar,
            'content_en'=>$this->content_en,
            'department'=> new DepartmentBreifResource($this->department),
            'region'=> new RegionBreifResource($this->region),
            'city'=> new CityResource($this->city),
            'ad_type'=>__('site.'.$this->ad_type),
            'parent_category'=> new CategoryBreifResource($this->parentCategory),
            'sub_category'=> new CategoryBreifResource($this->subCategory),
            'admodel'=> new AdmodelBreifResource($this->admodel),
            'price'=>$this->price,
            'set_price'=>is_null($this->price)? 0 : 1,
            'allow_comments'=>$this->allow_comments,
            'show_mobile'=>$this->show_mobile,
            'mobile_number'=>is_null($this->mobile_number)? $this->customer->mobile : $this->mobile_number,
            'customer'=> new CustomerBreifResource($this->customer),
            'views'=>$this->views,
        ];


        return $data;
    }
}
