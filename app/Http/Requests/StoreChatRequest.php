<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChatRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'content'=>'nullable|max:500',
            'customer2_id'=>'required',
            'image'=>'nullable|file|mimes:png,jpg,jpeg|max:10240'
        ];
    }
}
