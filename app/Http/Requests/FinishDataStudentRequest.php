<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinishDataStudentRequest extends FormRequest
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
            'course_ids' => 'required|array',
            'course_ids.*' => 'required|integer|exists:courses,id',
            "ack_video" => "required|mimes:mp4,mov,ogg,qt,flv,avi,wmv,rm,rmvb,mkv,3gp,mpeg,mpg,mpe,mpv,mpg4,ogv,webm,ts,mts,m2ts",
            "personal_pic" => "required|mimes:jpeg,jpg,png,gif,svg|max:10000",

        ];
    }
}
