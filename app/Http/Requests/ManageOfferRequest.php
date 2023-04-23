<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageOfferRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules= [
            'title_ar'=>'required|max:200',
            'title_en'=>'required|max:200',
            'content_ar'=>'required|max:500',
            'content_en'=>'required|max:500',
            'pic'=>['required','file','mimes:png,jpg,jpeg','max:10240']
        ];
        if($this->record_id){
            $rules['pic'][0] = 'nullable';
            $rules['status']='required|in:active,inactive';
        }
        return $rules;
    }

    public function attributes(){
        return ['pic'=>__('validation.attributes.picture')];
    }
}
