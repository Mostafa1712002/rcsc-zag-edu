<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\SentChatResource;
use Illuminate\Broadcasting\PrivateChannel;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewChat implements ShouldBroadcastNow{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chat;
    private $receiver_id;
    public function __construct(SentChatResource $chat, $receiver_id){
        $this->chat = $chat;
        $this->receiver_id = $receiver_id;
    }

    public function broadcastOn(){
        return new PrivateChannel('user_chats_'.$this->receiver_id);
    }
}
