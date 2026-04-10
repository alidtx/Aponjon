<?php

namespace App\Http\Controllers\Auth;

use App\Events\EmailNotVerified;
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
use Illuminate\Validation\ValidationException;

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
            throw ValidationException::withMessages([
                'message' => 'অত্যধিক লগইন চেষ্টা করা হয়েছে। অনুগ্রহ করে ' . $loginAttemptTimeout . ' মিনিট পরে আবার চেষ্টা করুন.',
            ]);
        }

        if (! $user || ! Hash::check($request->password, $user->password) || Cache::has($lockExpiryKey)) {
            Cache::put($cacheKey, $attempts + 1, now()->addMinutes((int) $loginAttemptTimeout));
            throw ValidationException::withMessages([
                'message' => 'প্রদত্ত ক্রেডেনশিয়াল সঠিক নয়। অনুগ্রহ করে সঠিক তথ্য দিন',
            ]);
        }
        Cache::forget($cacheKey);

        if (!$user->is_verified) {
            EmailNotVerified::dispatch($user);
            return redirect()->route('otp.verify');
        }
        Auth::login($user);
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
