<?php

namespace App\Http\Controllers\Api;

use App\Models\Filter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\FilterResource;
use Illuminate\Support\Facades\Schema;

class FilterController extends Controller{
    public function store(FilterRequest $request){
        $cols = array_filter(Schema::getColumnListing('filters'),function($element){
            return $element !='id' && $element !='created_at' && $element != 'updated_at';
        });

        $cols = array_map(function($el){
            return null;
        },array_flip($cols));

        $conditions = array_merge($cols,$request->validated());

        return new FilterResource(Filter::firstOrCreate($conditions));
    }

    public function get($id){
        $filter = Filter::query()->find($id);
        return response()->json(new FilterResource($filter));
    }

    public function check(){
        return response()->json([
            'follow'=>Filter::query()
                    ->when(request('department_id'),function($query,$department_id){
                        return $query->whereDepartmentId($department_id);
                    })->when(request('parent_category_id'),function($query,$parent_category_id){
                        return $query->whereParentCategoryId($parent_category_id);
                    })->when(request('sub_category_id'),function($query,$sub_category_id){
                        return $query->whereSubCategoryId($sub_category_id);
                    })->when(request('region_id'),function($query,$region_id){
                        return $query->whereRegionId($region_id);
                    })->when(request('city_id'),function($query,$city_id){
                        return $query->whereCityId($city_id);
                    })->when(request('admodel_id'),function($query,$admodel_id){
                        return $query->whereAdmodelId($admodel_id);
                    })->when(request('ad_status'),function($query,$ad_status){  /// _/
                        return $query->whereAdStatus($ad_status);
                    })->when(request('car_agency_id'),function($query,$car_agency_id){  /// _/
                        return $query->whereCarAgenciesId($car_agency_id);
                    })->when( request('district'),function($query, $district){
                        $index = '%'.$district.'%';
                        return $query->where(function($query) use($index){
                            return $query->orWhere('district','like',$index);
                        });
                    })->when(request('ad_type'),function($query,$ad_type){
                        return $query->whereAdType($ad_type);
                    })
                    ->whereIn('id',auth('api-customers')->user()->following('filter')->pluck('followable_id'))
                    ->exists()]);
    }
}
