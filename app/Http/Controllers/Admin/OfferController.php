<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Offer;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageOfferRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ManageUserFormRequest;

class OfferController extends Controller{

    protected $model;
    public function __construct(Offer $model){
        $this->model = $model;
        $this->redirect = redirect()->route('admin.offer.index');
        $this->views_path = 'pages.admin.offers';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.offers')
        ];
        return view($this->views_path.'.index',$data);
    }

    public function create(){
        $data = [
            'page_title'=>__('site.add_new_offer')
        ];
        return view($this->views_path.'.create',$data);
    }

    public function store(ManageOfferRequest $request){
        $pic = $request->pic;
        $pic = $request->pic->storeAs(date('Y/m/d'),Str::random(25).'_'.mt_getrandmax().'.'.$pic->extension(),'uploads');
        $pic_path = Storage::disk('uploads')->path($pic);
        $logo_path = Storage::disk('uploads')->path('watermark-logo.png');
        Image::make($pic_path)->insert($logo_path,'center')->save($pic_path);

        $data = array_merge($request->validated(),['pic'=>$pic,'status'=>'active']);
        Offer::create($data);
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }


    public function edit(Offer $offer){
        $data = [
            'page_title'=>$offer->{"title_".app()->getLocale()},
            'record'=>$offer
        ];
        return view($this->views_path.'.edit',$data);
    }


    public function update(ManageOfferRequest $request, Offer $offer){
        $pic = $offer->pic;
        ini_set('memory_limit', '256M');
        if($request->hasFile('pic')){
            $pic = $request->pic;
            $pic = $request->pic->storeAs(date('Y/m/d'),Str::random(25).'_'.mt_getrandmax().'.'.$pic->extension(),'uploads');
            $pic_path = Storage::disk('uploads')->path($pic);
            $logo_path = Storage::disk('uploads')->path('watermark-logo.png');
                Image::make($pic_path)
                    ->insert($logo_path,'center')
                    ->save($pic_path);
        }


        $data = array_merge($request->validated(),['pic'=>$pic]);
        $offer->update($data);
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }


    public function destroy(Offer $offer){
        $offer->delete();
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }
}
