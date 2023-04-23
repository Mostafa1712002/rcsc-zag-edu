<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $code = mt_rand(1999,9999);
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

    public function edit(Request $request){
        return view('pages.front.pages.profile.edit');
    }

    public function update(UpdateCustomerProfileRequest $request){

        $customer = auth('customer')->user();
        $data = $request->validated();
        $picture = $request->picture;
        $data['picture'] = ($request->hasFile('picture'))?
            $picture->storeAs(date('Y/m/d'),Str::random(25).'_'.time().'.'.$picture->extension(),'uploads') : $customer->picture;
        $customer->update($data);
        return redirect()->to(route('customer.profile'))->with('success_message',__('site.saved'));
    }
}
