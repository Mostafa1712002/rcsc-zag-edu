<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageWasRead implements ShouldBroadcastNow{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat,$unread_count;
    private $receiver_id;
    public function __construct(Chat $chat,$unread_count,$receiver_id){
        $this->chat = $chat;
        $this->unread_count = $unread_count;
        $this->receiver_id = $receiver_id;
    }

    public function broadcastOn(){
        return new PrivateChannel('user_chats_'.$this->receiver_id);
    }
}
