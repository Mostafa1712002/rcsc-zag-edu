<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Http\Requests\LikeRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;

class LikeController extends Controller
{
    public function toggle(LikeRequest $request,Ad $ad){
        $customer = auth('api-customers')->user();
        abort_if($customer->id == $ad->customer_id,422,__('site.you_cant_like_your_own_ad'));
        $like = $customer->likes()->updateOrCreate(
            ['ad_id'=>$ad->id],
            ['type'=>$request->action_type],
        );
        return new LikeResource($like);
    }
}
