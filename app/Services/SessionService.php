<?php

namespace App\Services;

use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SessionService
{
    const SIMPLE_LOGIN_MOBILE = 'simple_login_mobile';

    const SIMPLE_LOGIN_OTP = 'simple_login_otp';

    const MERCHANT_REG_EMAIL = 'merchant_reg_email';

    const MERCHANT_REG_OTP = 'merchant_reg_otp';

    const MERCHANT_FORGOT_OTP = 'merchant_forgot_otp';

    const QUIZ_PARTICIPANT = 'quiz_participant';

    public static function setByKey(string $key, $value): void
    {
        session()->put($key, $value);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getByKey(string $key)
    {
        return session()->get($key);
    }

    public static function getAuthenticateMerchant(Request $request)
    {
        return $request->session()->get('auth.admin');
    }

    public static function getAccessToken(Request $request)
    {
        return $request->session()->get('auth.access_token');
    }

    public static function getAuthenticateClient(Request $request)
    {
        return $request->session()->get('auth.client');
    }

    public static function clean(Request $request): void
    {
        $request->session()->forget('auth');

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
