<?php

namespace App\Services;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Collection;

class ChatService
{
    public static function getChatUsers(User $user): Collection
    {
        $chatUsers = User::where(function ($query) use ($user) {
                $query->whereHas('sentMessages', function ($q) use ($user) {
                    $q->where('receiver_id', $user->id);
                })->orWhereHas('receivedMessages', function ($q) use ($user) {
                    $q->where('sender_id', $user->id);
                });
            })
            ->where('id', '!=', $user->id)
            ->select('id', 'name', 'email')
            ->get();

        foreach ($chatUsers as $chatUser) {

            $lastMessage = Message::where(function ($query) use ($user, $chatUser) {
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', $chatUser->id);
                })
                ->orWhere(function ($query) use ($user, $chatUser) {
                    $query->where('sender_id', $chatUser->id)
                          ->where('receiver_id', $user->id);
                })
                ->latest()
                ->first();

            $chatUser->last_message = $lastMessage;

            $chatUser->unread_count = Message::where('sender_id', $chatUser->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();
        }

        return $chatUsers;
    }

    public static function getMessages(User $authUser, User $chatUser): Collection
    {
        $messages = Message::where(function ($query) use ($authUser, $chatUser) {
                $query->where('sender_id', $authUser->id)
                      ->where('receiver_id', $chatUser->id);
            })
            ->orWhere(function ($query) use ($authUser, $chatUser) {
                $query->where('sender_id', $chatUser->id)
                      ->where('receiver_id', $authUser->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        Message::where('sender_id', $chatUser->id)
            ->where('receiver_id', $authUser->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true
            ]);

        return $messages;
    }

     public static function send(User $sender, array $data): Message
    {
        $message = Message::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $data['receiver_id'],
            'message'     => $data['message'],
            'is_read'     => false,
        ]);

        $message->load('sender');

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }
    public static function markAsRead(User $authUser, int $userId): bool
    {
        Message::where('sender_id', $userId)
            ->where('receiver_id', $authUser->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true
            ]);

        return true;
    }
}