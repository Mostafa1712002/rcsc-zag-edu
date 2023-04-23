<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Http\Requests\AbuseRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbuseResource;

class AbuseController extends Controller
{
    public function store(AbuseRequest $request,Ad $ad){
        $customer_id = auth('api-customers')->id();
        abort_if($ad->abuses()->whereCustomerId($customer_id)->count(),400,__('site.already_reported'));

        if($ad->abuses()->count()==9){
            $ad->update(['status'=>'inactive']);
        }

        $data = array_merge($request->validated(),['customer_id'=>$customer_id]);
        return new AbuseResource($ad->abuses()->create($data));
    }
}
