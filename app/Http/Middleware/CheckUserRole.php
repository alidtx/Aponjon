<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{

    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = SessionService::getAuthenticateClient($request);

        if (!$user) {
            return to_route('login');
        }

        $allowedRoles = explode('|', $roles);
        
        if (in_array($user->role, $allowedRoles)) {
            return $next($request);
        }

        abort(403, 'Access denied. Insufficient permissions.');
    }

}