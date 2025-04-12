<?php

namespace App\Events;

use App\Models\Message;
use App\Models\GroupMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class GroupMessageSent implements ShouldBroadcastNow
{
    public $message;
    public $groupId;

    public function __construct(Message $message, $groupId)
    {
        $this->message = $message;
        $this->groupId = $groupId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("group-chat.{$this->groupId}");
    }

    public function broadcastAs()
    {
        return 'GroupMessageSent';
    }
}
