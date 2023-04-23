<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatMessageRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'message'=>'nullable|string',
            'image'=>'nullable|file|mimes:png,jpg,jpeg|max:5600'
        ];
        return $rules;
    }
}
