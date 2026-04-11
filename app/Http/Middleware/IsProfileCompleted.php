<?php

namespace App\Http\Middleware;

use App\Enum\Role;
use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user =SessionService::getAuthenticateUser($request);

        if (!$user) {
            return to_route('login');
        }

        if (!$user->is_profile_completed) {

            if ($request->routeIs([
                'admin.create.profile',
                'tasker.create.profile',
                'customer.create.profile',
              
            ])) {
                return $next($request);
            }

            return match ($user->role) {
                Role::Admin->value => to_route('admin.create.profile'),
                Role::Customer->value => to_route('customer.create.profile'),
                Role::Tasker->value =>   to_route('tasker.create.profile'),
            };
        }

        return $next($request);
    }
}
