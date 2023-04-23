<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FollowRequest;

class FollowController extends Controller{
    public function store(FollowRequest $request){
        $followable_type = $request->type;
        $followable_id = $request->id;
        $customer_id = auth('customer')->id();

        abort_if($followable_type=='customer' && $followable_id==$customer_id,442,__('site.you_cant_follow_yourself'));

        $data = compact('followable_type','customer_id');
        $model = "App\Models\\".ucfirst($followable_type);
        if($model::find($followable_id)->followers()->whereCustomerId($customer_id)->exists()){
            $response = ['status'=>'unfollow','text'=>__('site.follow')];
            $model::find($followable_id)->followers()->whereCustomerId($customer_id)->delete();
        }else{
            $response = ['status'=>'follow','text'=>__('site.unfollow')];
            $model::find($followable_id)->followers()->create($data);
        }
        return response()->json($response);
    }

    public function following(FilterFollowingRequest $request){
        return FollowResource::collection(auth('api-customers')->user()->following($request->type)->paginate());
    }

    public function followers(){
        return FollowResource::collection(auth('api-customers')->user()->followers()->paginate(1));
    }
}
