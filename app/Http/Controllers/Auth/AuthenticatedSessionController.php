<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Cache;;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {

        $user = UserService::findbyEmail($request->email);

        $cacheKey = $user?->login_attempts_cache_key;
        $maxLoginAttempts = config('aponjon.static_data.max_login_attempts');
        $loginAttemptTimeout = config('aponjon.static_data.login_attempt_timeout_in_minutes');

        $attempts = Cache::get($cacheKey, 0);
        $lockExpiryKey = $user?->login_attempts_timeout_cache_key;

        if ($attempts >= (int) $maxLoginAttempts) {
            Cache::put($lockExpiryKey, now()->addMinutes((int) $loginAttemptTimeout)->timestamp, $loginAttemptTimeout * 60);

            return back()->withErrors([
                'message' => 'Too many login attempts. Please try again in ' . $loginAttemptTimeout . ' minutes.',
            ]);
        }

        if (! $user || ! Hash::check($request->password, $user->password) || Cache::has($lockExpiryKey)) {
            Cache::put($cacheKey, $attempts + 1, now()->addMinutes((int) $loginAttemptTimeout));

            return back()->withErrors([
                'message' => 'The provided credentials are incorrect',
            ]);
        }
        Cache::forget($cacheKey);

        if (is_null($user->is_Verified) || $user->is_Verified === false) {
            return redirect()->route('otp.verify', [
                'email' => $user->email,
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
