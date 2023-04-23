<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Http\Resources\FavrotieResource;

class FavoriteController extends Controller
{
     public function toggle(request $request,Ad $ad){
        $customer = auth('api-customers')->user();
        abort_if($customer->id == $ad->customer_id,422,__('site.you_cant_favorite_your_own_ad'));
        $favorited = $customer->favorites()->whereAdId($ad->id)->exists();
        if($favorited){
            $customer->favorites()->whereAdId($ad->id)->delete();
        }else{
            $customer->favorites()->create(['ad_id'=>$ad->id]);
        }
        return new AdResource($ad);
    }

    public function index(Request $request){
        return AdResource::collection(
            Ad::whereStatus('active')->find(auth('api-customers')->user()->favorites()->pluck('ad_id'))->paginate()
        );
    }
}
