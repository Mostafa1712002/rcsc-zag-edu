<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterCustomerFormRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        $rules =  [
            'first_name'=>'required|max:200',
            'terms_accepted'=>'present',
            'country_code'=>'required|exists:countries,iso_code',
            'mobile'=>'required|integer|unique:customers,mobile|phone:'.$this->country_code,
            'picture'=>'image',
            'password'=>[
                'required',
                'min:6',
                function ($attribute, $value, $fail){
                    if (strstr($value,' ')) {
                        $fail(__('site.no_whitespaces_allowed_in_password'));
                    }
                },
            ],
            'password_confirmation'=>[
                'required',
                'min:6',
                'same:password',
                    function ($attribute, $value, $fail){
                    if (strstr($value,' ')) {
                        $fail(__('site.no_whitespaces_allowed_in_password_confirmation'));
                    }
                },
            ],
            'device_id'=>'nullable'
            // 'email'=>'email|max:200|unique:customers,email',
            // 'country_id'=>'required|numeric|exists:countries,id',
            // 'address'=>'required',
            // 'city_id'=>'required|numeric|exists:cities,id',
            // 'area_id'=>'required|numeric|exists:areas,id',
            // 'via_map'=>'required',
        ];
        return $rules;
    }



    public function messages()
    {
        $locale = app()->getLocale();
        return [
            'country_code.exists'=>__('general.country_doesnt_exist'),
            'terms_accepted.*'=>__('site.you_must_agree_on_terms_and_conditions'),
            'password.regex'=>__('site.no_whitespaces_allowed_in_password'),
            'password_confirmation.regex'=>__('site.no_whitespaces_allowed_in_password_confirmation'),
            'mobile.phone'=>__('site.mobile_format_incorrect')
        ];
    }

}
