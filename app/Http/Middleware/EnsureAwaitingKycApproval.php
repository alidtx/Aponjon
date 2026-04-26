<?php

namespace App\Http\Middleware;

use App\Services\RedirectionService;
use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAwaitingKycApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = SessionService::getAuthenticateClient($request);

        if ($user['status'] != 'approved' && $user['is_profile_completed']) {
            return $next($request);
        }

        return RedirectionService::roleBasedRedirect($user);
    }
}
