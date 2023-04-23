<?php

namespace App\Http\Controllers\Api;
use Image;
use App\Models\Ad;
use App\Models\AdVisit;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\DeleteAdRequest;
use App\Http\Requests\AddAdFormRequest;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller{
    public function myAds(){
        return AdResource::collection(
            auth('api-customers')
            ->user()
            ->ads()
            ->withTrashed()
            ->paginate(5)
        );
    }

    public function store(AddAdFormRequest $request){
        $pics = [];
        if(is_array($request->pics) && count($request->pics)){
            $path =date('Y/m/d');
            foreach($request->pics as $k=>$pic){
                $hashed_name = Str::random(25).'_'.mt_getrandmax().'.'.$pic->extension();
                $new_pic = $pic->storeAs($path,$hashed_name,'public');
                $new_pic_path = Storage::disk('uploads')->path('pics/'.$new_pic);
                $logo_path = Storage::disk('uploads')->path('watermark-logo.png');
                Image::make($new_pic_path)->insert($logo_path,'bottom-right',10,0)->save($new_pic_path);
                Image::make($new_pic_path)->resize(354,168)->save(Storage::disk('uploads')->path('pics/'.$path.'/thumb_'.$hashed_name));
                $pics[] = $new_pic;
            }
        }

        $data = array_merge($request->validated(),compact('pics'));


        return new AdResource(
            auth('api-customers')->user()->ads()->create($data)
        );
    }

     public function update(AddAdFormRequest $request,Ad $ad){

        abort_if($ad->customer_id != auth('api-customers')->id(),403,__('site.not_allowed'));
        $pics = [];
        $path =date('Y/m/d');
        if(is_array($request->pics)){
            foreach($request->pics as $k=>$v){
                $pics[] = $v->storeAs($path,Str::random(25).'_'.mt_getrandmax().'.'.$v->extension(),'public');
            }
        }

        $pics = $request->existing_pics? array_merge($request->existing_pics,$pics) : $pics;
        $data = array_merge($request->validated(),['pics'=>$pics]);

        $ad->update($data);
        Cache::forget('ad-'.$ad->id);
        return new AdResource($ad);
    }

    public function customer(Customer $customer){
        return AdResource::collection($customer->ads()->isActive()->paginate(5));
    }

    public function similar(Ad $ad){
        $fileds = ['department_id','parent_category_id','sub_category_id','admodel_id','city_id'];
        return AdResource::collection(Ad::isActive()->where(function($query) use ($fileds,$ad){
            return $query->orWhere($ad->only($fileds));
        })->where('id','!=',$ad->id)->orderByDesc('updated_at')->paginate(5));
    }

    public function show($ad_id){

        $ad = Cache::remember('ad-'.$ad_id, now()->addMinutes(10), function() use($ad_id) {
            return Ad::with(['parentCategory','subCategory','region','admodel','city'])->findOrFail($ad_id);
        });

        //$is_owner = auth('api-customers')->id()? (auth('api-customers')->id()==$ad->customer_id? true : false) : false;
        abort_if(($ad->status=='inactive' || $ad->deleted_at !=null) && auth('api-customers')->id() != $ad->customer_id,404,__('site.not_found'));

        if($user = auth('api-customers')->user()){
            AdVisit::query()->with('cars_agency')->firstOrCreate([
                'customer_id'=>$user->id,
                'ad_id'=>$ad->id
                ],['visits'=>0])->increment('visits');
        }
        return new AdResource($ad);
    }

    public function delete(DeleteAdRequest $request, Ad $ad){
        abort_if($ad->customer_id != auth('api-customers')->id(),403,__('site.not_allowed'));
        Cache::forget('ad-'.$ad->id);
        $ad->update(['delete_reason'=>$request->delete_reason]);
        $ad->delete();
        return response()->json();
    }

    public function renewAd(Ad $ad){
        abort_if($ad->customer_id != auth('api-customers')->id(),403,__('site.not_allowed'));
        abort_unless($ad->updated_at->diffInHours()>=72,400,__('site.cant_renew_ad_before_72_of_last_renewal'));
        Cache::forget('ad-'.$ad->id);
        $ad->update(['updated_at'=>now()]);
        return new AdResource($ad);

    }
}
