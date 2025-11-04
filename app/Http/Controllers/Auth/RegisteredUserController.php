<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Services\OtpService;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
   
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

   
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        
        $user=UserService::register($request);
        event(new Registered($user));


        // Auth::login($user);

        return redirect()->route('dashboard');
    }
}
