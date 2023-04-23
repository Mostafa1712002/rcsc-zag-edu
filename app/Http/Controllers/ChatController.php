<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Events\NewChat;
use App\Models\Customer;
use App\Models\ChatMessage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\MessageWasRead;
use App\Events\NewChatMessage;
use App\Http\Resources\ChatResource;
use App\Http\Requests\StoreChatRequest;
use App\Http\Resources\SentChatResource;
use App\Http\Resources\ChatMessageResource;
use App\Http\Resources\CustomerBreifResource;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;

class ChatController extends Controller{
    public function index(){
        $customers = Customer::get();
        $data = [
            'customers'=>$customers,
            'page_title'=>__('site.chat')
        ];
        return view('pages.front.chat.index',$data);
    }

    public function getChats(){
        $customer_id = auth('customer')->id();

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

    public function getCustomerChats(Customer $customer){
         $messages = ChatMessage::where(function($query) use($customer){
                    return $query
                            ->where(['customer2_id'=>auth('customer')->id(),'customer1_id'=>$customer->id])
                            ->orWhere(function($q) use ($customer){
                                return $q->where(['customer1_id'=>auth('customer')->id(),'customer2_id'=>$customer->id]);
                            });
                })->when(request('last_message_id'),function($query,$last_message_id){
                    return $query->where('id','<',$last_message_id);
                })->limit(8)->orderByDesc('id')->get();
        return response()->json([
            'messages'=>ChatMessageResource::collection($messages),
            'customer'=>new CustomerBreifResource($customer)
        ]);
    }

    public function store(StoreChatRequest $request){
        $is_new_chat = 0;

        $customer2_id = $request->customer2_id;
        $chat = Chat::where([
            'customer1_id'=>auth('customer')->id(),
            'customer2_id'=>$customer2_id
        ])->orWhere(function($query) use ($customer2_id){
            return $query->where([
                'customer2_id'=>auth('customer')->id(),
                'customer1_id'=>$customer2_id
            ]);
        })->first();

        if(!$chat){
            $is_new_chat = 1;
            $chat = Chat::create([
                'customer1_id'=>auth('customer')->id(),
                'customer2_id'=>$customer2_id
            ]);
        }

        $image = $request->image?
            $request->image->storeAs(date('Y/m/d'),Str::random(50).'.'.$request->image->extension(),'public') : null;

        $chat_message = $chat->chatMessages()->create([
            'customer1_id'=>auth('customer')->id(),
            'customer2_id'=>$customer2_id,
            'content'=>$request->content,
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
        $subject_id = auth('customer')->id();
        spark_send_fcm($notifiable,$title,$body,compact('content_ar','content_en','title_ar','title_en','type','subject_id'),0);
        return response()->json(new ChatResource($chat));
    }

    public function readAllChatMessages(Chat $chat){
        $other_customer_id = auth('customer')->id()==$chat->customer1_id? $chat->customer2_id : $chat->customer1_id;
        $unread_relation = $chat->chatMessages()->unread();

        $unread_count = $unread_relation->receiver($other_customer_id)->count();
        ChatMessage::where(['chat_id'=>$chat->id,'customer2_id'=>auth('customer')->id()])->whereNull('read_at')->update(['read_at'=>now()]);
        // $unread_relation->receiver(auth('customer')->id())->update(['read_at'=>now()]);

        broadcast(new MessageWasRead($chat,$unread_count,$other_customer_id));
        return response()->json();
    }
}
