<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
 public function index()
    {
        $user = auth()->user();

        $chatUsers = User::whereHas('sentMessages', function ($q) use ($user) {
            $q->where('receiver_id', $user->id);
        })->orWhereHas('receivedMessages', function ($q) use ($user) {
            $q->where('sender_id', $user->id);
        })
        ->where('id', '!=', $user->id)
        ->select('id', 'name', 'email')
        ->get();

        // Add last message and unread count
        foreach ($chatUsers as $chatUser) {
            $lastMessage = Message::where(function ($q) use ($user, $chatUser) {
                $q->where('sender_id', $user->id)->where('receiver_id', $chatUser->id);
            })->orWhere(function ($q) use ($user, $chatUser) {
                $q->where('sender_id', $chatUser->id)->where('receiver_id', $user->id);
            })->latest()->first();
            
            $chatUser->last_message = $lastMessage;
            $chatUser->unread_count = Message::where('sender_id', $chatUser->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();
        }

        return Inertia::render('Customer/Chats/Index', [
            'chatUsers' => $chatUsers,
            'authUser' => $user,
        ]);
    }

    public function getMessages(User $user)
    {
        $authUser = auth()->user();
        
        $messages = Message::where(function ($q) use ($authUser, $user) {
            $q->where('sender_id', $authUser->id)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($authUser, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $authUser->id);
        })->orderBy('created_at', 'asc')->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $authUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        // Load sender relationship
        $message->load('sender');

        // Broadcast to receiver's private channel
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function markAsRead($userId)
    {
        Message::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

}
