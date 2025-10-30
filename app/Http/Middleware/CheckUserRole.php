<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{

    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Access denied. User not logged in.');
        }

        $allowedRoles = explode('|', $roles);
        
        if (in_array($user->role, $allowedRoles)) {  
            return $next($request);
        }

        abort(403, 'Access denied. Insufficient permissions.');
    }

}