<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller{
    public function index(Request $request){
        $relation = auth('api-customers')->user()->notifications();
        if(in_array($request->status,['read','unread'])){
                $relation = $relation->{request('status')}();
        }
        return  NotificationResource::collection($relation->paginate());
    }

    public function unread ()
    {
        $relation = auth('api-customers')->user()->unreadNotifications;
        return response()->json([
            'status' => 'success',
            'count' => $relation->count()??0
        ]);
    }
}


