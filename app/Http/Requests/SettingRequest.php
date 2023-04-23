<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\Rules\Phone;
class SettingRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        $linkedin_pattern = '(https?)?:?(\/\/)?(([w]{3}||\w\w)\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?';
        $facebook_pattern = '(?:(?:http|https):\/\/)?(?:www.|m.)?facebook.com\/(?!home.php)(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\.-]+)';
        $twitter_pattern = 'http(?:s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)';
        $instagram_pattern = '(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am|instagr.com)\/(\w+)';
        $youtube_pattern = '(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?';
        return [
            'website'=>'nullable|active_url',
            'snapchat'=>'nullable|active_url',
            'fax'=>'nullable|phone:sa',
            'whatsapp'=>'nullable|phone:sa',
            'email'=>'nullable|email:dns,rfc|max:200',
            'mobile_number'=>'nullable|phone:sa',
            'linkedin'            => [
                'nullable',
                'max:200',
                'active_url',
                function ($attribute, $value, $fail) use($linkedin_pattern){
                    if (!preg_match('/'.$linkedin_pattern.'/', $value)) {
                        $fail(__('site.enter_a_valid_linkedin_link'));
                    }
                },
            ],
            'facebook'=> [
                'nullable',
                'max:200',
                'active_url',
                function ($attribute, $value, $fail) use($facebook_pattern){
                    if (!preg_match('/'.$facebook_pattern.'/', $value)) {
                        $fail(__('site.enter_a_valid_facebook_link'));
                    }
                },
            ],
            'twitter'=>[
                'nullable',
                'max:200',
                'active_url',
                function ($attribute, $value, $fail) use($twitter_pattern){
                    if (!preg_match('/'.$twitter_pattern.'/', $value)) {
                        $fail(__('site.enter_a_valid_twitter_link'));
                    }
                },
            ],
            'instagram'            => [
                'nullable',
                'max:200',
                'active_url',
                function ($attribute, $value, $fail) use($instagram_pattern){
                    if (!preg_match('/'.$instagram_pattern.'/', $value)) {
                        $fail(__('site.enter_a_valid_instagram_link'));
                    }
                },
            ],
            'youtube'=>[
                'nullable',
                'max:200',
                'active_url',
                function ($attribute, $value, $fail) use($youtube_pattern) {
                    if (!preg_match('/'.$youtube_pattern.'/', $value)) {
                        $fail(__('site.enter_a_valid_youtube_link'));
                    }
                },
            ],
            'commission_percent'=>'required|numeric|lt:100|gte:0',
            'bank_account_id'=>'required|max:32'
        ];
    }
}
