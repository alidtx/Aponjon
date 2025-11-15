<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\OtpService;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class OtpVerificationController extends Controller
{
  public function showVerificationForm()
  {

    if (!Session::has('otp_verified_user_id')) {
          return redirect()->route('register');
      }
    return Inertia::render('Auth/VerifyOtp',);
  }

  public function verify(Request $request)
  {

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
      throw ValidationException::withMessages([
        'otp' => 'অনেকবার চেষ্টা করা হয়েছে। অনুগ্রহ করে ' . $loginAttemptTimeout . ' মিনিট পরে আবার চেষ্টা করুন।'
      ]);
    }

    if ($user->latestOtp?->code !== $request->otp) {
      Cache::put($cacheKey, $attempts + 1, now()->addMinutes((int) $loginAttemptTimeout));
      throw ValidationException::withMessages([
        'otp' => 'ওটিপি সঠিক নয়! অনুগ্রহ করে আবার চেষ্টা করুন।',
      ]);
    }

    $lastOtp = $user->latestOtp;

    if (Carbon::now()->greaterThan($user->latestOtp->expires_at)) {
      $lastOtp->delete();
      throw ValidationException::withMessages([
        'otp' => 'ওটিপি মেয়াদোত্তীর্ণ হয়েছে! অনুগ্রহ করে নতুন ওটিপি কোড অনুরোধ করুন।',
      ]);
    }

    $user->update([
      'is_verified' => true,
    ]);

    $user->latestOtp->delete();
    Auth::login($user);
    return redirect()->route('dashboard');
  }
}
