<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\RatingResource;

class RatingController extends Controller
{
    public function store(RatingRequest $request){
        $value = $request->rating_value;
        $ratingable_type = $request->type;
        $ratingable_id = $request->id;
        $customer_id = auth('api-customers')->id();

        abort_if($ratingable_type=='customer' && $ratingable_id==$customer_id,442,__('site.you_cant_rate_yourself'));

        $model = "App\Models\\".ucfirst($ratingable_type);
        $ratingable_type = $model;

        return new RatingResource(
            $model::find($ratingable_id)->ratingsOn()->updateOrCreate(['ratingable_type'=>$ratingable_type,'customer_id'=>auth('api-customers')->id()],['value'=>$value])
        );
    }
}
