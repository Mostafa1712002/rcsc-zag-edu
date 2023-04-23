<?php

namespace App\Http\Controllers\Front;

use App\Models\Ad;
use App\Models\Region;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAdRequest;
use App\Models\AdVisit;

class AdController extends Controller{
    public function show(Ad $ad){
        abort_if(($ad->status!='active' && auth('customer')->id() != $ad->customer_id) ||!is_null($ad->deleted_at) ,404);

        if($ad->status=='active'){
            AdVisit::firstOrCreate([
            'customer_id'=>auth('customer')->id(),
            'ad_id'=>$ad->id
            ],['visits'=>0])->increment('visits');
        }


        $customer_visited = auth('customer')->user() && auth('customer')->user()->visits()->whereAdId($ad->id)->exists();
        $can_follow = (auth('customer')->check() && auth('customer')->id() != $ad->customer_id)? 1 : 0;

        $interactions = $ad->likes()->get(['type']);
        $likes_count = $interactions->filter(function($interaction){
            return $interaction->type=='like';
        })->count();

        $dislikes_count = $interactions->filter(function($interaction){
            return $interaction->type=='dislike';
        })->count();


        $data = [
            'page_title'=>$ad->title_ar,
            'record'=>$ad->load(['customer']),
            'customer_visited'=>$customer_visited,
            'followable_type'=>'ad',
            'can_follow'=>$can_follow,
            'is_following'=>$can_follow? auth('customer')->user()->isFollowing($ad->id,'ad') : 0,
            'likes_count'=>$likes_count,
            'dislikes_count'=>$dislikes_count
        ];
        return view('pages.front.ads.show',$data);
    }

    public function renewAd(Ad $ad){
        if(auth('customer')->id() == $ad->customer_id && $ad->updated_at->diffInHours(now())>=72){
            $ad->update(['updated_at'=>now()]);
            return redirect()->back()->withSuccessMessage(__('site.ad_renewed_successfully'));
        }else{
            return redirect()->back()->withErrorMessage(__('site.ad_cant_be_renewed_72_hours'));
        }
    }

    public function delete(DeleteAdRequest $request,Ad $ad){
        abort_unless(auth('customer')->id() == $ad->customer_id,403,'Forbidden');
        $ad->update(['status'=>'inactive','delete_reason'=>request('delete_reason')]);
        $ad->comments()->delete();
        $ad->followers()->delete();
        $ad->delete();
        return response()->json(['message'=>__('site.ad_deleted_successfully')]);
    }


    public function create(){
        $locale = app()->getLocale();
        $data = [
            'page_title'=>__('site.create_ad')
        ];
        return view('pages.front.ads.create',$data);
    }

     public function edit(Ad $ad){
        $locale = app()->getLocale();
        $data = [
            'page_title'=>__('site.edit_ad'),
            'ad'=>$ad
        ];
        return view('pages.front.ads.edit',$data);
    }
}
