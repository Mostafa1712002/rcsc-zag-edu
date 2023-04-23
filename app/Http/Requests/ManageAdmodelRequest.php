<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageAdmodelRequest extends FormRequest
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
            'title_ar'=>'required|min:2|max:100',
            'title_en'=>'required|min:2|max:100',
            'parent_category_id'=>'required|exists:categories,id',
            'sub_category_id'=>'required|exists:categories,id',
            'department_id'=>'required|exists:departments,id',
            'status'=>'required|in:active,inactive'
        ];
    }
}
