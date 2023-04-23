<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRegisterCodeRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'code' => 'required|numeric|digits:4',
            'country_code'=>'required|exists:countries,iso_code',
            'mobile'=>'required|phone:sa'
        ];
    }
}
