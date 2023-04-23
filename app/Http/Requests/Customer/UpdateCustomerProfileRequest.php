<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerProfileRequest extends FormRequest{

    public function authorize(){
        return true;
    }


    public function rules(){
        $id = auth('api-customers')->id()? auth('api-customers')->id() : auth('customer')->id();
        return [
            'first_name'=>'required|max:200',
            'picture'=>'nullable|file|mimes:png,jpg,jpeg|max:10240',
            'country_code'=>'nullable|exists:countries,iso_code',
            'email'=>'nullable|max:200|email:dns,rfc|unique:customers,email,'.$id,
            'mobile'=>'required|integer|digits:9|unique:customers,mobile,'.$id.'|phone:sa',
        ];
    }

    public function messages(){
        return [
            'mobile.integer'=>__('site.mobile_number_cant_start_with_zero')
        ];
    }
}
