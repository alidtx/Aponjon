<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerChatController extends Controller
{
 public function index()
    {   
      
         $chatUsers=ChatService::getChatUsers(auth()->user()); 
          return Inertia::render('Customer/Chats/Index', [
            'chatUsers' => $chatUsers,
            'authUser' => auth()->user(),
        ]);
    }

    public function getMessages(User $user)
    {
        $messages=ChatService::getMessages(auth()->user(), $user);
        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);
         $message = ChatService::send( auth()->user(),$request->only('receiver_id', 'message'));
        return response()->json($message);
    }

    public function markAsRead($userId)
    {
    
    ChatService::markAsRead(auth()->user(), $userId);

    return response()->json([
        'success' => true
    ]);
    }

}
