<?php

namespace App\Http\Controllers\Api\Customer;

use Validator;
use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerDevice;
use App\Services\NewOTPService;
use App\Services\OurSMSService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogoutRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\GenerateCodeService;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\CustomerResource;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\SaveResetPasswordRequest;
use App\Http\Requests\RequestResetPasswordRequest;
use App\Http\Requests\VerifyForgetPasswordCodeRequest;
use App\Http\Requests\Customer\LoginCustomerFormRequest;
use App\Http\Requests\Customer\RegisterCustomerFormRequest;
use App\Http\Requests\ResendCustomerVerificationCodeRequest;
use App\Http\Requests\VerifyRegisterCodeRequest;

class AuthController extends Controller{
    public function show(Customer $customer){
        return new CustomerResource($customer);
    }

    public function register(RegisterCustomerFormRequest $request){
        $inputs = $request->validated();
        unset($inputs['password_confirmation'],$inputs['terms_accepted']);
        $password = $inputs['password'];
        $inputs['password'] = bcrypt($inputs['password']);

        $inputs['picture'] = ($request->hasFile('picture'))? uploadImgFromMobile($request->picture, 'driver') : null;
        $customer = new Customer($inputs);


        if ($customer->save()){
            try {
                $token = auth('api-customers')->attempt(['mobile'=>$customer->mobile,'country_code'=>$customer->country_code,'password'=>$password]);
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            $code = GenerateCodeService::getCode();
            NewOTPService::generateCode('register_code',$customer['mobile'],$code);
            OurSMSService::sendOtp($customer->mobile, $code);

            return response()->json([
                'user' => CustomerResource::make($customer),
                'token' => $token
            ]);
        }
        return response()->json(['status'=>false,'message' => 'Something went Wrong', 400]);
    }


    public function login(LoginCustomerFormRequest $request){
        if (! $token = Auth::guard('api-customers')->attempt($request->validated())) {
            return response()->json(['status'=>0,'message' => __('general.invalidLoginData')], 401);
        }
        $customer = auth('api-customers')->user();

        CustomerDevice::firstOrCreate(['customer_id' => $customer->id,'device_token' => $request->device_token,'type' => $request->type ]);
        $other_user_device = CustomerDevice::where('customer_id','!=',$customer->id)->where(['device_token' => $request->device_token,'type' => $request->type])->first();
        if(!is_null($other_user_device)){
            $other_user_device->delete();
        }

        if($customer->status !='active'){
            return response()->json(['status'=>false,'message'=>__('general.your_account_is_pending')],401);
        }
        return ['token'=>$token,'user'=>new CustomerResource($customer)];
    }


    public function logout(LogoutRequest $request) {
        $device = CustomerDevice::
                    where(['customer_id'=>auth('api-customers')->id(),'device_token' => $request->device_token , 'type' => $request->type ])
                    ->delete();
        auth('api-customers')->logout();
        return response()->json(['message' => __('general.logged_out_sucessfully')]);
    }


    public function sendResetPasswordCode(RequestResetPasswordRequest $request){
        $customer = Customer::where('mobile', request('mobile'))->first();
        abort_unless($customer,400,__('site.wrong_account'));
        abort_if($customer->status =='inactive',400,__('general.your_account_is_pending'));





        $wait_for = $customer->reset_password_code_generated_at? $customer->reset_password_code_generated_at->addHours(1)->diffInSeconds(now()) : 0;

        if($customer->reset_password_num>2 && $wait_for>0){
            return response()->json([
                'message'=>__('site.sms_is_temp_disabled'),
                'wait_for'=>$wait_for
            ],400);
        }

        $code = GenerateCodeService::getCode();
        OurSMSService::sendOtp($customer->mobile, $code);
        $customer->update([
            'reset_password_code' => $code,
            'reset_password_num'=>($customer->reset_password_num+1)%4,
            'reset_password_code_generated_at'=>now()
        ]);

        return response()->json([
            'code' => $code,
            'message' => __('general.password_reset_email_was_sent'),
            'wait_for'=>$customer->reset_password_code_generated_at->addMinutes(1)->diffInSeconds(now())
        ]);
    }

    public function saveResetPassword(SaveResetPasswordRequest $request){
        abort_unless($customer = Customer::whereMobile(request('mobile'))->whereCountryCode(request('country_code'))->first(),400,__('site.wrong_account'));
        if ($customer->reset_password_code == request('code')) {
            $customer->update(['reset_password_code'=>null,'password'=>bcrypt(request('password'))]);
            return response()->json(['message' => __('general.saved'),'data'=> new CustomerResource($customer)]);
        }
        return response()->json(['status' => false, 'message' => __('general.invalid_code')], 422);
    }/**/

    public function verifyAccount(VerifyRegisterCodeRequest $request){
        $redis_code = Redis::get('register_code_code_value.'.$request->mobile);
        abort_if($request->code != $redis_code,400,__('trans.code_is_worng'));



        Customer::where('mobile',$request->mobile)
            ->update(['email_verified_at'=>Carbon::now(),'verification_code'=>null]);
        return response()->json(['message'=>__('general.your_account_has_been_verified')]);

    }

    public function resendActivationCode(ResendCustomerVerificationCodeRequest $request){
        $code = GenerateCodeService::getCode();
        $result = NewOTPService::generateCode('register_code',$request->mobile,$code);
        $result['message'] = $result['status']=='exceeded'? __('site.you_have_exceeded_maximum_allowed_trials') : __('site.please_wait');


        if($result['status']=='success'){
            $result['message'] = __('general.a_confirmation_code_was_sent_to_new_mobile_number');
            OurSMSService::sendOtp($request->mobile, $code);
        }
        return $result;
    }

    public function verifyForgetPasswordCode(VerifyForgetPasswordCodeRequest $request){
        $user = Customer::where('mobile', request('mobile'))->first();

        if ($user) {
            if ($user->reset_password_code == request('code')) {
                return response()->json(['status'=>  true,'message' => __('site.correct_code')]);
            }
            return response()->json(['status' => false, 'message' => __('site.invalid_code')], 422);
        }
        return response()->json(['status' => false, 'message' => __('site.wrong_account')], 400);
    }

}
