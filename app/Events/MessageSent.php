<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $receiverId;

    public function __construct(Message $message,$receiverId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
    }

     public function broadcastOn()
    {
        $sortedIds = [$this->message->sender_id, $this->message->receiver_id];
        sort($sortedIds);

        return new PrivateChannel("chat-channel.{$sortedIds[0]}.{$sortedIds[1]}");
    }

    public function broadcastAs()
    {
        return 'MessageSent'; // Explicit event name
    }




    // public function broadcastWith()
    // {
    //     return [
    //         'message' => $this->message,
    //        'attachment_url' => asset('storage/' . $this->message->attachment),   // Attachment URL
    //     ];
    // }



}
