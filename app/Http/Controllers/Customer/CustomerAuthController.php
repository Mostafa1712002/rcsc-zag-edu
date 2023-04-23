<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\OurSMSService;
use App\Http\Controllers\Controller;
use App\Services\GenerateCodeService;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\SaveResetPasswordRequest;
use App\Http\Requests\VerifyResetPasswordRequest;
use App\Http\Requests\Customer\LoginCustomerFormRequest;
use App\Http\Requests\Customer\RegisterCustomerFormRequest;

class CustomerAuthController extends Controller{
    public function showLoginForm(){
        return view('pages.front.pages.login');
    }

    public function showRegisterForm(){
        return view('pages.front.pages.register');
    }

    public function showVerifyForm(Customer $customer){
        return view('pages.front.pages.verify',['customer'=>$customer]);
    }

    public function showForgetPassword(){
        return view('pages.front.pages.forget_password');
    }

    public function requestForgetPasswordCode(ForgetPasswordRequest $request){
        $customer = Customer::where('mobile', request('mobile'))->first();
        if($customer->status=='inactive'){
            return redirect()->back()->withErrorMessage(__('general.your_account_is_pending'));
        }


        $wait_for = $customer->forget_password_wait_time;

        if($wait_for > 0 && $customer->reset_password_code_generated_at){
            return redirect()
            ->to(route('customer.verify_forget_password',$customer))
            ->with(['success_message'=>__('general.password_reset_email_was_sent')]);
        }

        // if($wait_for<0 && $customer->reset_password_num==4){

        // }

        if($customer->reset_password_num==3 && $wait_for>0){
            redirect()
            ->to(route('customer.verify_forget_password',$customer))
            ->with(['error_messaage'=>__('site.sms_is_temp_disabled')]);
        }

        $code = GenerateCodeService::getCode();
         if($wait_for<0 && $customer->reset_password_num==4){
            $reset_code_num=1;
        }else{
            $reset_code_num = $customer->reset_code_num>2? 1 : $customer->reset_password_num+1;
        }

        OurSMSService::sendOtp($customer->mobile, $code);
        $customer->update([
            'reset_password_code' => $code,
            'reset_password_num'=>$reset_code_num,
            'reset_password_code_generated_at'=>now()
        ]);

        return redirect()
            ->to(route('customer.verify_forget_password',$customer))
            ->with(['success_messaage'=>__('general.password_reset_email_was_sent')]);
    }

    public function forgetPasswordVerifyPage(Customer $customer){
        return view('pages.front.pages.verify_forget_password',['customer'=>$customer]);
    }

    public function verifyResetPassword(Request $request,Customer $customer){
        $code = request('code1',0).request('code2',0).request('code3',0).request('code4',0);
        if(
            $customer->reset_password_code==intval($code) &&
            $customer->forget_password_wait_time>0 && $customer->reset_password_num<4
        ){
            return redirect()->to(route('customer.show_reset_password_page',compact('customer','code')));
        }
        return redirect()->to(route('customer.verify_forget_password',['customer'=>$customer]))->withErrorMessage(__('site.invalid_code'));
    }

    public function showResetPasswordPage(Request $request,Customer $customer,$code){
        return view('pages.front.pages.reset_password',compact('customer','code'));
    }

    public function saveResetPassword(SaveResetPasswordRequest $request,Customer $customer,$code){

    }

    public function login(LoginCustomerFormRequest $request){
        $credentials = $request->except(['_token','remember']);

        if (auth('customer')->attempt($credentials,request('remember'))) {
            if(auth('customer')->user()->status !='active'){
                auth('customer')->logout();
                return redirect()->back()->with('error_message',__('site.your_account_has_been_deactivated'));
            }

            if(auth('customer')->user()->verification_code != null ){
                $customer = auth('customer')->user();
                $code = GenerateCodeService::getCode();
                OurSMSService::sendOtp($customer->mobile, $code);

                $customer->update([
                    'verification_code'=>$code,
                    'verification_code_generated_at'=>now()
                ]);
                auth('customer')->logout();
                return redirect()->to(route('verify',$customer->id));
            }


            return redirect()->route('home');
        }

        return redirect()->back()->with('error_message',__('site.invalid_login_data'));
    }

    public function register(RegisterCustomerFormRequest $request){
        $data = $request->validated();
        unset($data['password_confirmation'],$data['terms_accepted']);
        $new_customer = Customer::create(array_merge($data,['password'=>bcrypt($request->password)]));
        return redirect()->to(route('verify',$new_customer));
    }

    public function verify(Request $request,Customer $customer){
        abort_if(is_null($customer->verification_code),404);
        $code = intval(request('code1').request('code2').request('code3').request('code4'));

        if($customer->verification_code == $code){
            $customer->update([
                'verification_code'=>null,
                'verification_code_generated_at'=>null,
                'resend_verification_code_num'=>0,
                'email_verified_at'=>now()
            ]);
            return redirect()->to(route('customer.login'))->with('success_message',__('site.account_verified_successfully'));
        }
        return redirect()->to(route('verify',$customer->id))->with('error_message',__('site.invalid_verification_code'));
    }

    public function logout(){
        auth('customer')->logout();
        return redirect()->to(route('customer.login'))->with('success_message',__('site.logged_out_successfully'));
    }
}
