<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAdRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'delete_reason'=>'required|max:500|min:3'
        ];
    }
}
