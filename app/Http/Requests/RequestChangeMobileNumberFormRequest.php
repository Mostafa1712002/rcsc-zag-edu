<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RequestChangeMobileNumberFormRequest extends FormRequest
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
      $rules= [
       'mobile'=>[
           'required',
           Rule::unique('customers')->ignore($this->user()->id),
           'phone:'.$this->country_code
       ],
       'country_code'=>'required|exists:countries,iso_code'
      ];
      return $rules;
    }

    public function messages()
    {
        $locale = app()->getLocale();
        return [
            'country_code.exists'=>__('general.country_doesnt_exist'),
            'mobile.phone'=>($locale=='ar')? 'رقم الجوال غير صحيح بالنسبة للدولة المختارة' : 'Mobile number format is incorrect for selected country'
        ];
    }
}
