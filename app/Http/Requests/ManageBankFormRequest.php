<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageBankFormRequest extends FormRequest
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
            'title_ar'=>'required|min:2|max:200|unique:banks,title_ar,'.$this->record_id,
            'title_en'=>'required|min:2|max:200|unique:banks,title_en,'.$this->record_id,
            'status'=>'required|in:active,inactive'
        ];
    }
}
