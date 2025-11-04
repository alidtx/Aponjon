<?php
// app/Providers/EventServiceProvider.php
namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendOtpNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendOtpNotification::class,
        ],
    ];
}