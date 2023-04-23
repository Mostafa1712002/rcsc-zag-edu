<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Requests\AddCommentFormRequest;

class CommentController extends Controller{
    public function index(Ad $ad){
        return CommentResource::collection($ad->comments()->paginate());
    }

    public function store(AddCommentFormRequest $request,Ad $ad){
        $data = array_merge($request->validated(),['customer_id'=>auth('api-customers')->id()]);
        return new CommentResource($ad->comments()->create($data));
    }

    public function delete(Comment $comment){
        abort_if($comment->ad->customer_id != auth('api-customers')->id(),403,__('site.not_allowed'));
        CommentReply::whereCommentId($comment->id)->delete();
        $comment->delete();
        return CommentResource::collection(Comment::whereAdId($comment->ad_id)->paginate());
    }
}
