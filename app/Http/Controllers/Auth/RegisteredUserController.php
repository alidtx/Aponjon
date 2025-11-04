<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Session;
class RegisteredUserController extends Controller
{
   
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

   
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        
        $user=UserService::register($request);

        Session::put('otp_verified_user_id', $user->id);

        // Session::put('otp_identifier', $user->phone ?? $user->email);
        
        UserRegistered::dispatch($user);
        event(new Registered($user));
        
        return redirect()->route('otp.verify');
    }
}
