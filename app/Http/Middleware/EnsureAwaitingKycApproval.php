<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAwaitingKycApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {     
        $user =SessionService::getAuthenticateUser($request);
         
         if ($user['status'] != UserStatus::APPROVED->value && $user['is_profile_completed']) {
            return $next($request);
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
