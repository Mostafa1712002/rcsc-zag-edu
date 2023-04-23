<?php

namespace App\Http\Controllers\Front;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentFormRequest;

class CommentController extends Controller{
    public function loadMore(Ad $ad){
        return view('pages.front.ads.comments',['ad'=>$ad,'comments'=>$ad->comments()->orderBy('id','desc')->paginate()]);
    }

    public function store(AddCommentFormRequest $request,Ad $ad){
        $comment = $ad->comments()->create(array_merge($request->validated(),['customer_id'=>auth()->id()]));
        return view('pages.front.ads.comments',['comments'=>compact($comment)]);
    }
}
