<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\GenerateCodeService;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SaveChangeMobileNumberFormRequest;
use App\Http\Requests\RequestChangeMobileNumberFormRequest;
use App\Http\Requests\Customer\UpdateCustomerProfileRequest;

class ProfileController extends Controller{
    public function changePassword(ChangePasswordRequest $request){
        $customer = auth('api-customers')->user();
        $data = ['status'=>false,'message'=>__('general.incorrect_password')];
        $code = 422;
         if(Hash::check($request->old_password, $customer->password)){
          $customer->update(['password'=>bcrypt($request->new_password)]);
          $data = ['status'=>true,'message'=>__('general.saved')];
          $code = 200;
         }
         return response()->json($data,$code);
    }/*changePassword*/

    public function requestChangeMobileNumber(RequestChangeMobileNumberFormRequest $request){
        $code = GenerateCodeService::getCode();
        auth('api-customers')->user()->update(['change_mobile_code'=>$code]);
        return response()->json(['status'=>true,'code'=>$code,'message'=>__('general.a_confirmation_code_was_sent_to_new_mobile_number')]);
    }

    public function saveChangeMobileNumber(SaveChangeMobileNumberFormRequest $request){
        $customer = auth('api-customers')->user();
        $code = 422;
        $data = ['status'=>false,'message'=>__('general.incorrect_code')];
        if($customer->change_mobile_code == $request->code){
         $code = 200;
         $customer->update(['change_mobile_code'=>null,'mobile'=>$request->new_mobile,'country_code'=>$request->country_code]);
         $data = ['status'=>true,'message'=>__('general.saved')];
        }
        return response()->json($data,$code);
    }/*saveChangeMobileNumber*/

    public function getProfile(Request $request){
        return response()->json(['data'=>new CustomerResource(auth('api-customers')->user())]);
    }

    public function setProfile(UpdateCustomerProfileRequest $request){
        $customer = auth('api-customers')->user();
        $input = $request->validated();
        $input['picture'] = ($request->hasFile('picture'))?
            $request->picture->storeAs(date('Y/m/d'),Str::random(50).'.'.$request->picture->extension(),'public') : null;
        $customer->update($input);
        return response()->json(new CustomerResource(auth('api-customers')->user()));
    }

}
