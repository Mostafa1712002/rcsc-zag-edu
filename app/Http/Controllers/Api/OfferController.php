<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;

class OfferController extends Controller{
    public function index(){
        return OfferResource::collection(Offer::orderByDesc('id')->whereStatus('active')->paginate());
    }

    public function show(Offer $offer){
        return new OfferResource($offer);
    }
}
