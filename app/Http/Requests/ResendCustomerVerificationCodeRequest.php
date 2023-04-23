<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResendCustomerVerificationCodeRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'country_code'=>'required|exists:countries,iso_code',
            'mobile'=>'required|phone:sa'
        ];
    }
}
