<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller{
    public function getProfile(){

        $countriesForSelect = Country::orderBy('title_'.app()->getLocale())->get();

        $data = array_merge([
            'info'=>auth('admin')->user(),
            'pageTitle'=>__('general.profile')],
            $this->data,['countriesForSelect'=>$countriesForSelect,
            'admin_phone_code'=>auth('admin')->user()->phone_code
        ]);
        return view($this->view_path.'.admin_profile',$data);
    }/**/

    public function setProfile(ManageAdminRequest $request){
        $admin = auth('admin')->user();
        $res = ['status'=>0,'msg'=>__('general.you_cant_deactivate_all_admins')];
        if(!($request->is_active==0 && $admin->is_active == 1 && Admin::active()->count()==1)){

            $data = $request->validated();
            if(isset($data['password'])){
                $data['password'] = bcrypt($request->password);
            }
            $admin->update($data);
            $res['status'] = ($admin->wasChanged())? 1 : 0;
            $res['msg'] = ($res['status'])? __('general.saved') : __('general.nothingChanged');
        }
      return response()->json($res,200);
    }
}
