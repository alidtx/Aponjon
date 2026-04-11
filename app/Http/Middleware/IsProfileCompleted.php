<?php

namespace App\Http\Middleware;

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
                'admin.store.profile',
                'tasker.create.profile',
                'tasker.store.profile',
                'customer.create.profile',
                'customer.store.profile',
            ])) {
                return $next($request);
            }

            return match ($user->role) {
                'admin' => to_route('admin.create.profile'),
                'customer' => to_route('customer.create.profile'),
                'tasker' =>   to_route('tasker.create.profile'),
                default => redirect('/'),
            };
        }

        return $next($request);
    }
}
