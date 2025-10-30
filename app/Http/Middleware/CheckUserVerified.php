<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }
    
        if (!$user->is_verified) {
            abort(403, 'Please complete verification process.');
        }
        
        return $next($request);
    }

}