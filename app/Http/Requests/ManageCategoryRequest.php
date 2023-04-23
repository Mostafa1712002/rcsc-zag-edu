<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'title_ar'=>'required|min:3|max:100',
            'title_en'=>'required|min:3|max:100',
            'status'=>'required|in:active,inactive',
            'parent_id'=>'nullable|exists:categories,id',
            'department_id'=>'required|exists:departments,id'
        ];
    }
}
