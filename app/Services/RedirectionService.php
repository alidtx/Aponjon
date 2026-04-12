<?php

namespace App\Services;

use App\Enum\Role;
use App\Models\User;


class RedirectionService
{
    public static function roleBasedRedirect(User $user)
    {
        switch ($user->role) {
            case Role::Customer->value:
                return redirect()->route('customer.dashboard');

            case Role::Tasker->value:
                return redirect()->route('tasker.dashboard');
        }
    }
}
