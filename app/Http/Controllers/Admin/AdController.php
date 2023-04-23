<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeactivateAdRequest;
use App\Http\Requests\ManageUserFormRequest;

class AdController extends Controller{

    protected $model;
    public function __construct(Ad $model){
        $this->model = $model;
        $this->redirect = redirect()->route('admin.ad.index');
        $this->views_path = 'pages.admin.ads';
        $this->locale = app()->getLocale();
    }


    public function index(Request $request){
        $pull = app()->getLocale()=='ar'? 'right' : 'left';

        $data = [
            'page_title'=>__('site.ads')
        ];
        return view($this->views_path.'.index',$data);
    }

    public function show(Ad $ad){
//        return $ad->department_id;
        $ad->load(['customer','city','area','department','parentCategory','subCategory']);
        $data = ['record'=>$ad,'page_title'=>$ad->{"title_".$this->locale}];
        return view('pages.admin.ads.show',$data);
    }

    public function activate(Ad $ad){
        $ad->update(['status'=>'active','deactivation_reason'=>'']);
        return redirect()->back()->withSuccessMessage(__('site.saved'));
    }

    public function deactivate(DeactivateAdRequest $request, Ad $ad){
        $ad->update(['status'=>'inactive','deactivation_reason'=>$request->deactivation_reason]);
        return redirect()->back()->withSuccessMessage(__('site.saved'));
    }



}
