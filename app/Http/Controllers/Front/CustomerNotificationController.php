<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerNotificationController extends Controller{
    public function index(){
        $customer = auth('customer')->user();
        $records = $customer->notifications();
        $records->take(15)->update(['read_at'=>now()]);
        $data = [
            'page_title'=>__('general.notifications'),
            'notifications'=>$records->paginate()
        ];
        return view('pages.front.pages.profile.notifications',$data);
    }
}
