<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    // Log for debugging
    Log::info('Channel authorization', [
        'user_id' => $user->id,
        'channel_user_id' => $userId,
        'is_match' => (int) $user->id === (int) $userId
    ]);
    
    return (int) $user->id === (int) $userId;
});