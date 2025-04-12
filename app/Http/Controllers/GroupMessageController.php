<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupMessage;
use Illuminate\Http\Request;
use App\Events\GroupMessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class GroupMessageController extends Controller
{
    // Send a message in the group
    public function sendMessage(Request $request, $groupId)
{
    $request->validate([
        'content' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mp3,pdf,docx|max:5120',  // Example file types
    ]);

    $group = Group::findOrFail($groupId);

    // Ensure user is a member of the group
    if (!$group->users()->where('user_id', Auth::id())->exists()) {
        return response()->json(['error' => 'You are not a member of this group.'], 403);
    }

    $messageData = [
        'content' => $request->input('content'),
        'sender_id' => Auth::id(),
        'group_id' => $groupId,
    ];

    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        $messageData['attachment'] = $attachmentPath;
    }

    $message = $group->messages()->create($messageData);

    broadcast(new GroupMessageSent($message, $groupId));

    return response()->json($message);
}

    public function getMessages($groupId)
    {
        $messages = GroupMessage::where('group_id', $groupId)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }
}

