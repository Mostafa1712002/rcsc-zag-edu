<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarsAgenciesRequset extends FormRequest
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
            'title_ar'=>'required|min:3|max:100|unique:car_agencies,name_ar,'.$this->car_agency_id,
            'title_en'=>'required|min:3|max:100|unique:car_agencies,name_en,'.$this->car_agency_id,
            'image'=> $this->car_agency_id?'nullable':'required'.'|image|mimes:jpeg,png,jpg'
        ];

    }
}
