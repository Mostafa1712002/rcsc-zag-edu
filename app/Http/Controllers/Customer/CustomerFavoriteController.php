<?php

namespace App\Http\Controllers\Customer;

use App\Models\Ad;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerFavoriteController extends Controller{
    public function index(Request $request){

        $records =
            Ad::isActive()
            ->whereIn('id',auth('customer')->user()->favorites()->pluck('ad_id'))
            ->with(['customer','city','department'])
                ->withCount(['visits'=>function($query){
                    return $query->whereCustomerId(auth('customer')->id());
                }],'id')
                ->withSum('visits','visits');
        $ads_count = $records->count();

        $data = [
            'records_count'=>$ads_count,
            'records'=>$records->paginate(),
            'page_title'=>__('site.my_favorites')
        ];
        return view('pages.front.pages.profile.my-favorites',$data);
    }
}
