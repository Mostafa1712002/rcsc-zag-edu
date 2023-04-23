<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagePageFormRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'title_ar'=>'required|min:3|max:200',
            'title_en'=>'required|min:3|max:200',
            'content_ar'=>'required|max:250000|min:12',
            'content_en'=>'required|max:250000|min:12',
        ];
    }
}
