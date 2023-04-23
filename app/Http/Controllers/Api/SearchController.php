<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Models\Ad;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\AdBreifResource;
use Illuminate\Http\Request;

class SearchController extends Controller{
    public function index(FilterRequest $request){
        $data = collect($request->validated());
        $search_term = $request->search_term;
        $by_id = $data->except(['search_term'])->toArray();
        return AdResource::collection(
            Ad::isActive()
            ->where(function($query) use ($by_id,$search_term){
                $search_term = '%'.$search_term.'%';
                return $query
                        ->orWhere($by_id)
                        ->orWhere('title_ar','like',$search_term)
                        ->orWhere('title_en','like',$search_term)
                        ->orWhere('content_ar','like',$search_term)
                        ->orWhere('content_en','like',$search_term);
            })->paginate(5));

    }

    public function homeAds(Request $request){
//        return response()->json($request);
        return AdResource::collection(
            Ad::isActive()
            ->when(request('search_term'),function($query,$search_term){
                $search_term = '%'.$search_term.'%';
                return $query->where(function($query) use($search_term){
                    return $query->orWhere('title_ar','like',$search_term)
                        ->orWhere('title_en','like',$search_term)
                        ->orWhere('content_ar','like',$search_term)
                        ->orWhere('content_en','like',$search_term)
                        ->orWhere(function($query) use ($search_term){
                            return $query->whereHas('customer',function($query2) use ($search_term){
                                return $query2->where(function($query3) use ($search_term){
                                    return $query3->orWhere('first_name','LIKE','%'.$search_term.'%')
                                                  ->orWhere('last_name','LIKE','%'.$search_term.'%');
                                });
                            });
                        });

                });
            })->when(request('department_id'),function($query,$department_id){
                return $query->whereDepartmentId($department_id);
            })->when(request('parent_category_id'),function($query,$parent_category_id){
                return $query->whereParentCategoryId($parent_category_id);
            })->when(request('sub_category_id'),function($query,$sub_category_id){
                return $query->whereSubCategoryId($sub_category_id);
            })->when(request('city_id'),function($query,$city_id){
                return $query->whereCityId($city_id);
            })->when(request('region_id'),function($query,$region_id){
                return $query->whereRegionId($region_id);
            })->when(request('admodel_id'),function($query,$admodel_id){
                return $query->whereAdmodelId($admodel_id);
            })->when(request('ad_type'),function($query,$ad_type){
                return $query->whereAdType($ad_type);
            })->when(request('ad_status'),function($query,$ad_status){  /// _/
                return $query->whereAdStatus($ad_status);
            })->when(request('car_agency_id'),function($query,$car_agency_id){  /// _/
                return $query->whereCarAgenciesId($car_agency_id);
            })->when( request('district'),function($query, $district){
                    $index = '%'.$district.'%';
                    return $query->where(function($query) use($index){
                        return $query->orWhere('district','like',$index);
                    });
            })->when(request('ad_id'),function($query,$ad_id){
                return $query->where('id',$ad_id);
            })->with(['parentCategory','subCategory','customer','admodel','city','region','department'])
            ->orderByDesc('updated_at')
            ->paginate(5)
        );
    }

    public function myAds(Request $request){
        $relation=auth('api-customers')
                ->user()
                ->ads()
             ->when(request('search_term'),function($query,$search_term){
                $search_term = '%'.$search_term.'%';
                return $query->where(function($query) use($search_term){
                    return $query->orWhere('title_ar','like',$search_term)
                        ->orWhere('title_en','like',$search_term)
                        ->orWhere('content_ar','like',$search_term)
                        ->orWhere('content_en','like',$search_term);
                });
            })->when(request('department_id'),function($query,$department_id){
                return $query->whereDepartmentId($department_id);
            })->when(request('parent_category_id'),function($query,$parent_category_id){
                return $query->whereParentCategoryId($parent_category_id);
            })->when(request('sub_category_id'),function($query,$sub_category_id){
                return $query->whereSubCategoryId($sub_category_id);
            })->when(request('city_id'),function($query,$city_id){
                return $query->whereCityId($city_id);
            })->when(request('region_id'),function($query,$region_id){
                return $query->whereRegionId($region_id);
            })->when(request('admodel_id'),function($query,$admodel_id){
                return $query->whereAdmodelId($admodel_id);
            })->when(request('ad_type'),function($query,$ad_type){
                return $query->whereAdType($ad_type);
            })->when(request('ad_status'),function($query,$ad_status){  /// _/
                return $query->whereAdStatus($ad_status);
            })->when(request('car_agency_id'),function($query,$car_agency_id){  /// _/
                return $query->whereCarAgenciesId($car_agency_id);
            })->when( request('district'),function($query, $district){
                $index = '%'.$district.'%';
                return $query->where(function($query) use($index){
                    return $query->orWhere('district','like',$index);
                });
            })->when(request('ad_id'),function($query,$ad_id){
                return $query->where('id',$ad_id);
            });


            if(!$request->status){
                $relation = $relation->withTrashed();
            }else{
                if($request->status == 'deleted'){
                    $relation = $relation->onlyTrashed();
                }else{
                    $relation = $relation->whereStatus('active');
                }
            }
         return AdResource::collection(
            $relation->orderByDesc('updated_at')->paginate(5)
        );
    }
}
