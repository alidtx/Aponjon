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

class RegisteredUserController extends Controller
{
   
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

   
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        
        $user=UserService::register($request);

        UserRegistered::dispatch($user);
        event(new Registered($user));

        // Auth::login($user);

        return redirect()->route('dashboard');
    }
}
