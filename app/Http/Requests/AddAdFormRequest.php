<?php

namespace App\Http\Requests;

use App\Helpers\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class AddAdFormRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){

        $cars_department_id = Helpers::CARS;  // id => 1
        $trucks_department_id = Helpers::TRUCKS;  // id => 2
        $real_estate_department_id = Helpers::REAL_ESTATE;  // id => 3
        $hard_ware_department_id = Helpers::HARDWARE;  // id => 4
        $spare_parts_department_id = Helpers::SPARE_PARTS;
        $pets_department_id = Helpers::PETS;
        $clothes_department_id = Helpers::CLOTHES;
        $jobs_department_id = Helpers::JOBS;
        $services_department_id = Helpers::SERVICES;

        $others_department_id = Helpers::OTHERS;
        $plates_department_id = Helpers::PLATES;

        $rules = [
            'title_ar'=>'required|max:200',

            'department_id'=>'required|exists:departments,id',
            'parent_category_id'=>'required|exists:categories,id',
            'sub_category_id'=>'required|exists:categories,id',

            'region_id'=>'required|exists:regions,id',
            'city_id'=>'required|exists:cities,id',
            'ad_type'=>'required|in:demand,supply,leave',

            'allow_comments'=>'required|in:0,1',
            'show_mobile'=>'required|in:0,1',
            'mobile_number'=>[
                'required_if:show_mobile,1',
                'phone:'.auth('api-customers')->user()->country_code
            ],

            'price'=>'nullable|numeric|gte:0|digits_between:1,20',
            'content_ar'=>'required|max:10000',
            'pics'=>'nullable|array',
            'pics.*'=>'file|mimes:png,jpg,jpeg|max:10240',
            'admodel_id'=>'required|exists:admodels,id',
            'is_guaranteed'=>'nullable|in:0,1', // cars
            'factory_year'=>'nullable|integer|digits:4', //
        ];



        if ($this->department_id == $cars_department_id
            || $this->department_id == $trucks_department_id){

            $rules['ad_type']='required|in:demand,supply,leave';
            $rules['is_double']='nullable|in:0,1';

            $rules['gear_type']='nullable|in:manual,automatic';
            $rules['fuel_type']='nullable|in:gasoline,hybrid,diesel';

            $rules['ad_status']='nullable|in:new,used,junk';
            if ($this->department_id == $trucks_department_id){
                $rules['ad_status']='nullable|in:new,used';
                $rules['ad_type']='required|in:demand,supply,leave,rent';
            }else{
                // $rules['car_agencies_id']='required';
            }
        }elseif ($this->department_id == $real_estate_department_id){
            $rules['ad_type']='required|in:demand,supply,leave,rent';
            $rules['district']='nullable|string|max:200';
            $rules['admodel_id']='nullable|exists:admodels,id';

        }elseif ($this->department_id == $hard_ware_department_id){

            $rules['admodel_id']='nullable|exists:admodels,id';
            $rules['ad_type']='required|in:demand,supply';
            $rules['ad_status']='nullable|in:new,used';
            $rules['parent_category_id']='required';

        }elseif($this->department_id == $spare_parts_department_id || $this->department_id == $services_department_id ){
            $rules['admodel_id']='nullable|exists:admodels,id';
            $rules['sub_category_id']='nullable|exists:admodels,id';
        }elseif($this->department_id == $pets_department_id || $this->department_id == $clothes_department_id || $this->department_id == $jobs_department_id){
            $rules['admodel_id']='nullable|exists:admodels,id';
        }elseif($this->department_id == $others_department_id || $this->department_id == $plates_department_id){
            unset($rules['parent_category_id'], $rules['sub_category_id'], $rules['admodel_id']);
        }
        return $rules;

    }

    public function messages(){
        return [
            'ad_status.required' => __('general.add_status_required'),
            'ad_status.in' => __('general.add_status_in'),
        ];
    }

}
