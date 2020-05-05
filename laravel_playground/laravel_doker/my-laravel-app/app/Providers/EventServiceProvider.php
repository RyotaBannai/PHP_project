<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 全イベント（キー）とリスナ（値）
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\OrderShipped' => [
            App\Listeners\SendShipmentNotification::class,
            App\Listeners\SendByQueue::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('event.name', function ($a, $b){
           // do something.
        });
        Event::listen('event.*', function($a, $b){
            // the same procedure for associated with the same listener.
        });
    }
}
