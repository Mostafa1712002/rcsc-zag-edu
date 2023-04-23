<?php

namespace App\Http\Controllers\Front;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbuseRequest;

class AbuseController extends Controller{
    public function store(AbuseRequest $request,Ad $ad){
        $customer_id=auth('customer')->id();
        abort_if($ad->abuses()->whereCustomerId($customer_id)->count(),400,__('site.already_reported'));
        if($ad->abuses()->count()>=9){
            $ad->update(['status'=>'inactive']);
        }
        $ad->abuses()->create(array_merge($request->validated(),compact('customer_id')));



        return response()->json(['status'=>1,'message'=>__('site.report_saved_successfully')]);
    }
}
