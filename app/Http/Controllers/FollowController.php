<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\AdResource;
use App\Http\Requests\FollowRequest;
use App\Http\Resources\FollowResource;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\FilterFollowingRequest;

class FollowController extends Controller{
    public function store(FollowRequest $request){
        $followable_type = $request->type;
        $followable_id = $request->id;
        $customer_id = auth('api-customers')->id();

        abort_if($followable_type=='customer' && $followable_id==$customer_id,442,__('site.you_cant_follow_yourself'));

        $data = compact('followable_type','customer_id');
        $model = "App\Models\\".ucfirst($followable_type);
        if($model::find($followable_id)->followers()->whereCustomerId($customer_id)->exists()){
            $response = ['message'=>__('site.unfollowed_successfully')];
            $model::find($followable_id)->followers()->whereCustomerId($customer_id)->delete();
        }else{
            $response = ['message'=>__('site.followed_successfully')];
            $model::find($followable_id)->followers()->create($data);
        }
        return response()->json($response);
    }

    public function following(FilterFollowingRequest $request){
        if($request->type=='customer'){
            return CustomerResource::collection(
                Customer::whereStatus('active')->whereIn('id',auth('api-customers')->user()->following('customer')->pluck('followable_id'))->paginate()
            );
        }else{
            return AdResource::collection(
                Ad::whereStatus('active')->whereIn('id',auth('api-customers')->user()->following('ad')->pluck('followable_id'))->paginate()
            );
        }

    }

    public function followers(){
        return FollowResource::collection(auth('api-customers')->user()->followers()->paginate());
    }
}
