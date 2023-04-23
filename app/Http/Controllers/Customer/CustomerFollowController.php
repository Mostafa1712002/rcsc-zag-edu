<?php

namespace App\Http\Controllers\Customer;

use App\Models\Ad;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerFollowController extends Controller{
    public function index(Request $request){
        $following_customers = auth('customer')->user()->following('customer');
        $customers_relation = Customer::isActive()->withAvg('ratingsOn','value')->find($following_customers->pluck('followable_id'))->paginate();
        $customers = $customers_relation->paginate();
        $customers_count = $customers_relation->count();

        $following_ads = auth('customer')->user()->following('ad');
        $ads_relation =
            Ad::isActive()
                ->whereIn('id',$following_ads->pluck('followable_id'))
                ->with(['customer','city','department'])
                ->withCount(['visits'=>function($query){
                    return $query->whereCustomerId(auth('customer')->id());
                }],'id')
                ->withSum('visits','visits');
        $ads_count = $ads_relation->count();
        $ads = $ads_relation->paginate(1);

        $data = [
            'customers'=>$customers,
            'records_count'=>$ads_count,
            'customers_count'=>$customers_count,
            'records'=>$ads,
            'page_title'=>__('site.my_follows')
        ];
        return view('pages.front.pages.profile.my-follows',$data);
    }
}
