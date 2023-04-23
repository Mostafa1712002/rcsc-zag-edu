<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyContactRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(){
        return [
            'reply'=>'required|min:3|max:2000',
            'notes'=>'nullable|string|max:2000'
        ];
    }



}
