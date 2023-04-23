<?php

namespace App\Http\Controllers\Api\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Resources\Api\SettingResource;




class SettingController extends Controller
{
    public function all()
    {
        $setting = Setting::find(1);
        return response()->json(['status' => 'success','data'=> new SettingResource($setting) ,'message'=> ''])->setStatusCode(200);

    }
}
