<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendContactRequest extends FormRequest{

    public function authorize()    {
        return true;
    }

    public function rules() {
        return [
            'sender_name'=>'required|min:3|max:200',
            'sender_email'=>'required|email|max:200',
            'sender_country_code'=>'required|exists:countries,iso_code',
            'sender_mobile'=>'required|phone:'.$this->sender_country_code,
            'message'=>'required|min:3|max:500'
        ];
    }

    public function messages(){
        return [
            'sender_mobile.integer'=>__('site.mobile_number_cant_start_with_zero')
        ];
    }
}
