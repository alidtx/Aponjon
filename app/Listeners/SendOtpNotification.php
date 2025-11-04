<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Services\OtpService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpNotification implements ShouldQueue
{    
    use InteractsWithQueue;

    public function handle(UserRegistered $event): void
    {

        $user = $event->user;
       
        $phoneOrEmail = $user->phone ?? $user->email;

        if (!$phoneOrEmail) {
            Log::error('Mobile or email not found');

            return;
        }
        try {
            $otp = OtpService::generate($phoneOrEmail);

            if ($user->phone) {
                OtpService::sendOtp($user->phone, $otp->code);

            } else {
                Log::info("OTP sent to email: {$user->email}");
            }

        } catch (\Exception $exception) {
            Log::error("OTP sending failed: " . $exception->getMessage());
        }
    }


}
