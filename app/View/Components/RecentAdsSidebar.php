<?php

namespace App\View\Components;

use App\Models\Ad;
use Illuminate\View\Component;

class RecentAdsSidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    private $ads;
    public function __construct($ad=null){
        $this->ads = Ad::IsActive();
        if(!is_null($ad)){
            $ad = Ad::withTrashed()->find($ad);
            $fileds = ['department_id','parent_category_id','sub_category_id','admodel_id','city_id'];
            $this->ads = $this->ads->where(function($query) use ($fileds,$ad){
                return $query->orWhere($ad->only($fileds));
            })->where('id','!=',$ad->id);
        }
        $this->ads =
            $this->ads->take(5)
            ->with(['city:id,name_'.app()->getLocale(),'customer','department'])
            ->withCount(['visits'=>function($query){
                        return $query->whereCustomerId(auth('customer')->id());
                    }],'id')
            ->withSum('visits','visits')
            ->orderByDesc('updated_at')
            ->get(['id','title_'.app()->getLocale(),'price','views','pics','department_id','city_id','customer_id','ad_type','created_at']);
    }

    public function render(){
        $recent_ads = $this->ads;
        return view('components.recent-ads-sidebar',compact('recent_ads'));
    }
}
