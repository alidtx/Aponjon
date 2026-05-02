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
    ->select('id', 'name')
    ->get();

    return Inertia::render('Customer/Chats/Index', [
        'chatUsers' => $chatUsers,
        'authUser' => $user,
    ]);
}

    public function send(Request $request)
{
    $message = Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message
    ]);

    broadcast(new MessageSent($message))->toOthers();

    return response()->json($message);
}
}
