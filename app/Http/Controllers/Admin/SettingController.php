<?php

namespace App\Http\Controllers\Admin;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
class SettingController extends Controller
{
    protected $model;
    public function __construct(Setting $model){
        $this->model = $model;
        $this->redirect = redirect()->route('admin.setting.index');
        $this->views_path = 'pages.admin.settings';
    }


    public function index(){
        $data = [
            'record'=>$this->model->first(),
            'page_title'=>__('site.settings')
        ];
        return view($this->views_path.'.index',$data);
    }



    public function update(SettingRequest $request){
        $setting = Setting::find(1);
        $setting->update($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }






}
