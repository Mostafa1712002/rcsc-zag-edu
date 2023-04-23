<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'new_password'=>[
                'required',
                'confirmed',
                'min:6',
                'regex:/^\S*$/u'
            ],
            'old_password'=>'required'
        ];
    }

    public function messages()
    {
        $locale = app()->getLocale();
        return [
            // 'password.min'=>($locale=='ar')? 'يجب الا يقل طول كلمة المرور عن 8 و تحتوي على حروف، ارقام، حروف كابيتال، و رموز' : 'Password minimum length is 8, must contain uppercase letters, numbers, and symbols'
        ];
    }
}
