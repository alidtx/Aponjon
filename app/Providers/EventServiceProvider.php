<?php
// app/Providers/EventServiceProvider.php
namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\UserRegistered;
use App\Listeners\SendOrderConfirmation;
use App\Listeners\UpdateInventory;
use App\Listeners\NotifyWarehouse;
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