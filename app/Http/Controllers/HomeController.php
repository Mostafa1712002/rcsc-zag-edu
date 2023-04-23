<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;

class HomeController extends Controller{

    public function index(){
        $latest_ads = Ad::isActive()
                    ->when(request('search_term'),function($query,$search_term){
                        $search_term = '%'.$search_term.'%';
                        return $query->where(function($query) use($search_term){
                            return $query->orWhere('title_ar','like',$search_term)
                                ->orWhere('title_en','like',$search_term)
                                ->orWhere('content_ar','like',$search_term)
                                ->orWhere('content_en','like',$search_term);
                        });
                    })->when(request('department_id') && request('department_id')!=0 ,function($query){
                        return $query->whereDepartmentId(request('department_id'));

                    })->when(request('parent_category_id') && request('parent_category_id')!=0  ,function($query,$parent_category_id){
                        return $query->whereParentCategoryId(request('parent_category_id'));

                    })->when(request('sub_category_id') && request('sub_category_id')!=0,function($query,$sub_category_id){
                        return $query->whereSubCategoryId(request('sub_category_id'));

                    })->when(request('city_id') && request('city_id') != 0,function($query,$city_id){
                        return $query->whereCityId(request('city_id'));

                    })->when(request('region_id')  && request('region_id')!=0,function($query,$region_id){
                        return $query->whereRegionId(request('region_id'));

                    })->when(request('admodel_id') && request('admodel_id')!=0,function($query,$admodel_id){
                        return $query->whereAdmodelId(request('admodel_id'));

                    })->when( request('ad_type'),function($query){
                        return $query->whereAdType(request('ad_type'));
                    })->orderByDesc('updated_at')
                    ->with(['customer','city','department'])
                    ->withCount(['visits'=>function($query){
                        return $query->whereCustomerId(auth('customer')->id());
                    }],'id')
                    ->withSum('visits','visits')
                    ->paginate(12);




        $data = ['latest_ads'=>$latest_ads];

        return view('pages.front.pages.home',$data);
    }


}
