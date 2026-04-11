<?php

use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\CheckUserVerified;
use App\Http\Middleware\EnsureAwaitingKycApproval;
use App\Http\Middleware\IsProfileCompleted;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'role'=>CheckUserRole::class,
            'profile_completed'=>IsProfileCompleted::class,
            'awaiting_kyc_approval'=>EnsureAwaitingKycApproval::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
