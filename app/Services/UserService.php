<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public static function register($request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    public static function findbyEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public static function roleBaseRedirect(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'customer':
                return redirect()->route('customer.dashboard');

            case 'tasker':
                return redirect()->route('tasker.create.profile');

            default:
                return redirect()->route('dashboard');
        }
    }
}
