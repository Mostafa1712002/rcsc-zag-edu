<?php
namespace App\Http\Controllers\Customer;
    use App\Http\Controllers\Controller;
    use App\Models\Ad;

    class CustomerAdController extends Controller{
        public function index(){
            $latest_ads = Ad::withTrashed()->where('status','!=','inactive')
                ->whereCustomerId(auth('customer')->id())
                   ->orderByDesc('updated_at')
                    ->with(['customer','city','department'])
                    ->withCount(['visits'=>function($query){
                        return $query->whereCustomerId(auth('customer')->id());
                    }],'id')
                    ->withSum('visits','visits');
            return view('pages.front.pages.profile.my-ads',[
                'ads_count'=>$latest_ads->count(),
                'latest_ads'=>$latest_ads->paginate(10)
            ]);
        }
    }
