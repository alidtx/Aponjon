<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\OtpService;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class OtpVerificationController extends Controller
{
  public function showVerificationForm()
  {

    if (!Session::has('otp_verified_user_id')) {
          return redirect()->route('register');
      }
    return Inertia::render('Auth/VerifyOtp', );

  }

  public function verify(Request $request)
  {

    $request->validate([
      'otp' => 'required|string|size:6',
    ]);
    $userId = Session::get('otp_verified_user_id'); //user id

    $user = User::findOrFail($userId);
    $cacheKey = $user?->login_attempts_cache_key;
    $maxLoginAttempts = config('aponjon.static_data.max_login_attempts');
    $loginAttemptTimeout = config('aponjon.static_data.login_attempt_timeout_in_minutes');
    $attempts = Cache::get($cacheKey, 0);
    $lockExpiryKey = $user?->login_attempts_timeout_cache_key;

    if ($attempts >= (int) $maxLoginAttempts) {
      Cache::put($lockExpiryKey, now()->addMinutes((int) $loginAttemptTimeout)->timestamp, $loginAttemptTimeout * 60);
      Log::info('Too many login attempts. Please try again in ' . $loginAttemptTimeout . ' minutes.');
    }

    if ($user->latestOtp?->code !== $request->otp) {
      Cache::put($cacheKey, $attempts + 1, now()->addMinutes((int) $loginAttemptTimeout));

      Log::info('Invalid');
    }
    if (Carbon::now()->greaterThan($user->latestOtp->expires_at)) {
      Log::info('expired');
    }

    $user->update([
      'is_verified' => true,
    ]);

    $user->latestOtp->delete();
     Auth::login($user);
    return redirect()->route('dashboard');
  }
}
