<?php

namespace App\Http\Requests;

use App\Helpers\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * @var mixed
     */


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cars_department_id = Helpers::CARS;  // id => 1
        $trucks_department_id = Helpers::TRUCKS;  // id => 2
        $real_estate_department_id = Helpers::REAL_ESTATE;  // id => 3
        $hard_ware_department_id = Helpers::HARDWARE;  // id => 4

        $rules = [
            'search_term'=>'nullable|string',
            'department_id'=>'nullable|exists:departments,id',
            'parent_category_id'=>'nullable|exists:categories,id',
            'sub_category_id'=>'nullable|exists:categories,id',

            'city_id'=>'nullable|exists:cities,id',
            'region_id'=>'nullable|exists:regions,id',
            'ad_type'=>'nullable|in:supply,demand,leave',
            'admodel_id' => 'nullable|exists:admodels,id',
            'ad_status' => 'nullable|in:new,used',
            'district'=>'nullable|string'
        ];

        if ($this->department_id == $cars_department_id
            || $this->department_id == $trucks_department_id){

            $rules['is_double']='nullable|in:0,1';
            $rules['ad_type']='nullable|in:demand,supply,leave';
            $rules['ad_status']='nullable|in:new,used,junk';
            $rules['gear_type']='nullable|in:manual,automatic';
            $rules['fuel_type']='nullable|in:gasoline,hybrid,diesel';

            $rules['car_agencies_id'] = 'nullable|exists:car_agencies,id';

            $rules['ad_status']='nullable|in:new,used,junk';
            if ($this->department_id == $trucks_department_id){
                $rules['ad_status']='nullable|in:new,used';
                $rules['ad_type']='nullable|in:demand,supply,leave,rent';
            }else{
                $rules['car_agencies_id']='nullable';
            }
        }elseif (!$this->department_id == $real_estate_department_id){
            $rules['admodel_id'] = 'nullable|exists:admodels,id';
            $rules['ad_type'] = 'nullable|in:demand,supply,leave,rent';
        }elseif ($this->department_id == $hard_ware_department_id){
            $rules['ad_type']='nullable|in:demand,supply';
            $rules['ad_status']='nullable|in:new,used';
            $rules['admodel_id']='nullable|exists:admodels,id';
        }

//        if ($this->department_id == $cars_department_id
//            || $this->department_id == $trucks_department_id){
//            $rules['admodel_id']='required';
//            $rules['is_double']='required|in:0,1';
//            $rules['gear_type']='required_if:department_id,'.$cars_department_id.'|in:manual,automatic';
//            $rules['fuel_type']='required|in:gasoline,hybrid,diesel';
//            $rules['is_guaranteed']='required|in:0,1';
//            $rules['factory_year']='required|integer|digits:4'; //junkyard
//            $rules['ad_status']='required|in:new,used,junk';
//            if ($this->department_id == $trucks_department_id){
//                $rules['ad_status']='required|in:new,used';
//                $rules['ad_type']='required|in:demand,supply,leave,rent';
//            }else{
//
//            }
//        }elseif ($this->department_id == $real_estate_department_id){
//            $rules['ad_type']='required|in:demand,supply,leave,rent,waive';
//            $rules['district']='nullable|string';
//        }elseif ($this->department_id == $hard_ware_department_id){
//            $rules['ad_type']='required|in:demand,supply';
//            $rules['ad_status']='required|in:new,used';
//            $rules['admodel_id']='required';
//        }
        return $rules;

    }

    public function messages()
    {
        return [
            'ad_status.required' => __('general.add_status_required'),
            'ad_status.in' => __('general.add_status_in'),
        ];
    }
}

