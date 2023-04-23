<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommissionRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
           'transfer_receipt'=>'required|file|mimes:pdf,png,jpg,jpeg|max:10240',
           'full_name'=>'required|max:200',
           'commission_amount'=>'required|numeric|gt:0|lte:99999999999999999999',
           'bank_id'=>'required|exists:banks,id',
           'transfer_date'=>'required|date|date-format:Y-m-d|before_or_equal:today',
           'transfer_name'=>'required|max:200',
           'country_code'=>'required',
           'ad_id'=>'required|exists:ads,id',
           'notes'=>'nullable|string|max:500',
           'mobile'=>'required|integer|digits:9|exists:customers,mobile'
        ];
    }

    public function messages(){
        return [
            'transfer_date.before_or_equal'=>__('site.transfer_date_must_be_before_or_equal_to_today'),
            'mobile.integer'=>__('site.mobile_number_cant_start_with_zero')
        ];
    }
}
