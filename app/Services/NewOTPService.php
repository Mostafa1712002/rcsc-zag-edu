<?php
    namespace App\Services;
    use Illuminate\Support\Facades\Redis;
    class NewOTPService{

        public static function generateCode(
            $code_name,
            $user_id,
            $code,
            $period_in_seconds=3600,
            $code_expires_in_seconds=60,
            $max_times_per_period=3
        ){
            $times_key = $code_name.'_code_times.'.$user_id;
            $otp_key = $code_name.'_code_value.'.$user_id;

            if(!Redis::exists($times_key)){
                $value = 1;
                Redis::set($times_key,1,'EX',$period_in_seconds);
            }else{
                $value = intval(Redis::get($times_key))+1;
                if($value>$max_times_per_period){
                    return ['status'=>'exceeded','wait_for'=>Redis::ttl($times_key)];
                }


                if(Redis::exists($otp_key)){
                 return ['status'=>'wait','wait_for'=>Redis::ttl($otp_key)];
                }

                Redis::set($times_key,$value,'EX',$period_in_seconds);
            }


            Redis::set($otp_key,$code,'EX',$code_expires_in_seconds);
            return ['status'=>'success','wait_for'=>$code_expires_in_seconds];
        }


    }
