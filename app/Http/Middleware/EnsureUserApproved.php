<?php

namespace App\Http\Middleware;

use App\Enum\UserStatus;
use App\Enum\Role;
use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $user =SessionService::getAuthenticateClient($request);

    if (!$user->is_profile_completed) {

         if ($request->routeIs([
                'tasker.create.profile',
                'customer.create.profile',
              
            ])) {
                return $next($request);
            }

            return match ($user->role) {
                Role::Customer->value => to_route('customer.create.profile'),
                Role::Tasker->value =>   to_route('tasker.create.profile'),
            };
            
    }

    if ($user->status != UserStatus::APPROVED->value) {
        return to_route('kyc.awaiting-approval.index');
    }

    return $next($request);
    }
}
