<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
  public function index ()  
  {
      return Inertia::render('Customer/Chats/Index');
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
