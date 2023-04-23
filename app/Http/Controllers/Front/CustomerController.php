<?php

namespace App\Http\Controllers\Front;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller{
    public function show(Customer $customer){
        $can_follow = (auth('customer')->check() && auth('customer')->id() != $customer->id)? 1 : 0;
        $can_rate = $can_follow;
        $data = [
            'page_title'=>$customer->full_name,
            'customer'=>$customer,
            'ads'=>$customer->ads()->isActive()->with(['customer','city','department'])
                    ->withCount(['visits'=>function($query){
                        return $query->whereCustomerId(auth('customer')->id());
                    }],'id')
                    ->withSum('visits','visits')->orderByDesc('id')->paginate(12),
            'followable_type'=>'customer',
            'can_follow'=>$can_follow,
            'can_rate'=>$can_rate,
            'is_following'=>$can_follow? auth('customer')->user()->isFollowing($customer->id,'customer') : 0
        ];
        return view('pages.front.show_customer',$data);
    }
}
