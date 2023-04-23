<?php

namespace App\Http\Controllers\Front;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferController extends Controller{
    public function index(){
        $records = Offer::whereStatus('active')->orderByDesc('id')->paginate();
        $page_title = __('site.offers');
        $data = compact('records','page_title');
        return view('pages.front.offers.index',$data);
    }

    public function show(Offer $offer){

        $data = [
            'page_title'=>$offer->{"title_".app()->getLocale()},
            'record'=>$offer
        ];
        return view('pages.front.offers.show',$data);
    }

}
