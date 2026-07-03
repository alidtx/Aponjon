<?php

namespace App\Http\Middleware;

use App\Enum\UserStatus;
use App\Services\RedirectionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user()?->fresh();

        if ($user && $user->status != UserStatus::APPROVED->value && $user->is_profile_completed) {
            return $next($request);
        }

        return RedirectionService::roleBasedRedirect($user);
    }
}
