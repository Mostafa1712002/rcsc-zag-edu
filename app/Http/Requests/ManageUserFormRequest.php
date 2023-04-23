<?php

namespace App\Http\Requests;

use App\Rules\NoWhiteSpaces;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ManageUserFormRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'name'=>'required|max:100',
            'mobile'=>[
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'status'=>'required|in:active,inactive',
            'password'=>[
                'required',
                'max:10',
                'min:6'
            ],
            'password_confirmation'=>['required','same:password'],
            'email'=>[
                'required',
                'email:dns,rfc',
                Rule::unique('users')->whereNull('deleted_at'),
                'min:10',
                'max:100',

            ],
            'avatar'=>'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'deactivation_reason'=>'nullable|max:250',
        ];

        if($this->record_id){
            $rules['email'][2] = $rules['email'][2]->ignore($this->record_id);
            $rules['mobile'][0] = $rules['mobile'][0]->ignore($this->record_id);
            $rules['password'][0] = 'nullable';
            $rules['password_confirmation'][0]='nullable';
        }



        return $rules;
    }


}
