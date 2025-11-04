<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Random\RandomException;

class OtpService
{
    /**
     * @throws RandomException
     */
    public static function generate($value): Otp|Model|null
    {
        $otp = random_int(100000, 999999);

        $user = User::query()
            ->where(function ($query) use ($value) {
                $query->where('email', $value)
                    ->orWhere('mobile', $value);
            })
            ->first();
        if (! $user) {
            return null;
        }

        $expiryKey = config('aponjon.static_data.otp_expiry_time_in_minutes');

        return Otp::query()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'code' => $otp,
                'expires_at' => Carbon::now()->addMinutes((int) $expiryKey),
            ]
        );
    }

    /**
     * @throws RandomException
     */
    public static function generateOtp($value)
    {
        
    }

    public static function sendOtp(string $mobile, string $otp)
    {
        
    }
}
