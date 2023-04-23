<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OurSMSService {

    public static function sendOtp($number, $otp){
        $token = config('our_sms.api_token');
        $endpoint = config('our_sms.endpoint');
        $message = 'رمز التحقق: '.$otp;
        file_get_contents($endpoint.'?token='.$token.'&src=Ardwtalb&dests=966'.$number.'&body="'.$message.'"');
    }

    public static function sendOtp_notWorkingFromTheirSide($number,$otp){
        $endpoint = "https://api.oursms.com/api-a/msgs";
        $api_key = 'PDlKhD7EXChx8isY3UIX';
        $data = [
            'src'=>'ardwtalb',
            'dests'=>['966'.$number],
            'body'=>'رمز التحقق: '.$otp
        ];
        $response = Http::withBody(json_encode($data), 'application/json')
            ->withOptions([
                'headers' => [
                    "Content-Type: application/json",
                    "Authorization: Bearer PDlKhD7EXChx8isY3UIX"
                ]
            ])->post($endpoint);
        \Log::info($response->json());
    }


}
