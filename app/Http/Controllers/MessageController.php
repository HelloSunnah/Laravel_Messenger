<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{

    public function getConversation($userId)
    {
        $loggedInUserId = Auth::id();
        $rec_name = User::select('name')->where('id', $userId)->first();

        $messages = Message::where(function ($query) use ($loggedInUserId, $userId) {
            $query->where('sender_id', $loggedInUserId)->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($loggedInUserId, $userId) {
                $query->where('sender_id', $userId)->where('receiver_id', $loggedInUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        foreach ($messages as $message) {
            if ($message->attachment) {
                $message->attachment_url = Storage::url($message->attachment);
            }
        }

        return response()->json([
            'messages' => $messages,
            'loggedInUserId' => $loggedInUserId,
            'userName' => $rec_name
        ]);
    }

    public function sendMessage(Request $request)
    {
        $loggedInUserId = Auth::id();

        // Validate the request
        $request->validate([
            'content' => 'nullable|string',
            'receiver_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $message = new Message([
            'sender_id' => $loggedInUserId,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'attachment' => $attachmentPath,
        ]);

        $message->save();

        broadcast(new MessageSent($message, $request->receiver_id));

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message
        ]);
    }
}
