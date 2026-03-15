<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\TaskerProfile;
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

    public static function storeTaskerProfile($request)
    {
        return TaskerProfile::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'nid_number' => $request->nid_number,
            'skills' => $request->skills,
            'experience' => $request->experience,
            'district_id' => $request->district_id,
            'zila_id' => $request->zila_id,
            'upozila_id' => $request->upozila_id,
            'hourly_rate' => $request->hourly_rate,
            'nid_front' => $request->nid_front,
            'nid_back' => $request->nid_back,
            'is_terms_and_condition_accept' => $request->is_terms_and_condition_accept,
        ]);
    }
}
