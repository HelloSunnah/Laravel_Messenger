<?php

use App\Models\Group;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::routes();

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat-channel.{senderId}.{receiverId}', function ($user, $senderId, $receiverId) {
    // Only allow the sender or receiver to listen to the channel
    return (int) $user->id === (int) $senderId || (int) $user->id === (int) $receiverId;
});

Broadcast::channel('group-chat.{groupId}', function ($user, $groupId) {
    return Group::find($groupId)->members->contains($user->id);
});
