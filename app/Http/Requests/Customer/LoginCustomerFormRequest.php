<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class LoginCustomerFormRequest extends FormRequest
{
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
        return [
            'mobile'=>[
                'required',
                // 'integer',
                'phone:'.$this->country_code
            ],
            'password' => 'required|string|min:6',
            'country_code'=>'required|exists:countries,iso_code',
        ];
    }


    public function messages()
    {
        $locale = app()->getLocale();
        return [
            'country_code.exists'=>__('general.country_doesnt_exist'),
            'mobile.phone'=>($locale=='ar')? 'رقم الجوال غير صحيح ' : 'Mobile number format is incorrect'
        ];
    }
}
