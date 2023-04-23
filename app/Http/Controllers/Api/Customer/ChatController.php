<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Chat;
use App\Events\NewChat;
use App\Models\Customer;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\InChatRequest;
use App\Http\Resources\ChatResource;
use App\Http\Requests\StoreChatRequest;
use App\Http\Resources\SentChatResource;
use App\Http\Resources\ChatMessageResource;
use App\Http\Resources\CustomerBreifResource;

class ChatController extends Controller{
    public function store(StoreChatRequest $request){
        $is_new_chat = 0;

        $customer2_id = $request->customer2_id;
        $chat = Chat::where([
            'customer1_id'=>auth('api-customers')->id(),
            'customer2_id'=>$customer2_id
        ])->orWhere([
            'customer2_id'=>auth('api-customers')->id(),
            'customer1_id'=>$customer2_id
        ])->first();

        if(!$chat){
            $is_new_chat = 1;
            $chat = Chat::create([
                'customer1_id'=>auth('api-customers')->id(),
                'customer2_id'=>$customer2_id
            ]);
        }


        $image = $request->image?
            $request->image->storeAs(date('Y/m/d'),Str::random(50).'.'.$request->image->extension(),'public') : null;

        $chat_message = $chat->chatMessages()->create([
            'customer1_id'=>auth('api-customers')->id(),
            'customer2_id'=>$customer2_id,
            'content'=>$request->get('content'),
            'image'=>$image
        ]);

        if($is_new_chat){
            broadcast(new NewChat(new SentChatResource($chat),$customer2_id))->toOthers();
        }else{
            broadcast(new NewChatMessage($chat_message))->toOthers();
        }


        $title_ar = 'عرض و طلب';
        $title_en = 'ArdWTalab';
        $notifiable = Customer::find($customer2_id);
        $content_en = 'New Message';
        $content_ar = 'رسالة جديدة';
        $title = ($notifiable->default_language=='ar')? $title_ar : $title_en;
        $body = ($notifiable->default_language=='ar')? $content_ar : $content_en;
        $type = 'new_message';
        $subject_id = auth('api-customers')->id();
        spark_send_fcm($notifiable,$title,$body,compact('content_ar','content_en','title_ar','title_en','type','subject_id'),0);

        return response()->json(new ChatResource($chat));
    }

    public function getCustomerChats(Customer $customer){
        $messages = ChatMessage::where(function($query) use($customer){
                    return $query
                            ->where(['customer2_id'=>auth('api-customers')->id(),'customer1_id'=>$customer->id])
                            ->orWhere(function($q) use ($customer){
                                return $q->where(['customer1_id'=>auth('api-customers')->id(),'customer2_id'=>$customer->id]);
                            });
                })->when(request('last_message_id'),function($query,$last_message_id){
                    return $query->where('id','<',$last_message_id);
                })->limit(8)->orderByDesc('id')->get();

        return response()->json([
            'messages'=>ChatMessageResource::collection($messages),
            'customer'=>new CustomerBreifResource($customer)
        ]);
    }

    public function getCustomerChatSearch(Request $request){
        $messages = ChatMessage::query()->where('content','like','%'.$request->get('message'))
            ->where(function ($q){
              $q->where('customer1_id', auth('api-customers')->id())
                  ->orWhere('customer2_id', auth('api-customers')->id());
            })->get();
        return response()->json([
            'status'=>'success',
            'messages'=>ChatMessageResource::collection($messages),
        ]);
    }

    public function getRooms(){
        $customer_id = auth('api-customers')->id();
        return response()->json(
            ChatResource::collection(
                Chat::where(function($query) use ($customer_id){
                    return $query->where('customer1_id',$customer_id)->orWhere('customer2_id',$customer_id);
                })->where(function($query){
                    return $query->whereHas('customer1',function($query2){
                        return $query2->whereStatus('active');
                    })->whereHas('customer2',function($query2){
                        return $query2->whereStatus('active');
                    });
                })
                ->orderByDesc('updated_at')
                ->paginate()
            )
        );
    }

    public function inChat(InChatRequest $request){
        auth('api-customers')->user()->update(['in_chat'=>$request->in_chat]);
        return response()->json(['status'=>'saved']);
    }

    public function unread(){
        return response()->json([
           'status' => 'success',
           'count' => auth('api-customers')->user()->unreadChatMessages()->count()??0
        ]);
    }

}
