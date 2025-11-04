<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Random\RandomException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function register($request)
    {
        $identifier = $request->input('identifier');

         $user = User::create([
            'name' => $request->name,
            'email' => filter_var($identifier, FILTER_VALIDATE_EMAIL) ? $identifier : null,
            'phone' => !filter_var($identifier, FILTER_VALIDATE_EMAIL) ? $identifier : null,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return $user; 

    }

  
}
