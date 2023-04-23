<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcastNow{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public function __construct(ChatMessage $message){
        $this->message = $message;
        $this->message->image = $message->image? url('uploads/pics/'.$message->image) : null;
    }



    public function broadcastOn(){
        return [
            new PrivateChannel('chat_'.$this->message->chat_id),
            new PrivateChannel('user_chats_'.$this->message->customer2_id)
        ];
    }
}
