<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Requests\CommentReplyRequest;
use App\Http\Resources\CommentReplyResource;

class CommentReplyController extends Controller{
    public function index(Comment $comment){
        return CommentReplyResource::collection($comment->replies()->latest()->paginate());
    }

    public function delete(CommentReply $comment_reply){
        $ad = $comment_reply->comment->ad;
        abort_if($ad->customer_id != auth('api-customers')->id(),403,__('site.not_allowed'));
        $comment_reply->delete();
        return CommentReplyResource::collection($comment_reply->comment->replies()->latest()->paginate());
    }

    public function store(CommentReplyRequest $request,Comment $comment){
        $comment->replies()->create([
            'customer_id'=>auth('api-customers')->id(),
            'ad_owner_id'=>auth('api-customers')->id(),
            'content'=>$request->content
        ]);
        return CommentReplyResource::collection($comment->replies()->paginate());
    }
}
