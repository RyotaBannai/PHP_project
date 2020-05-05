<?php

namespace App\Listeners;

use App\Events\OrderShipped;

use App\Jobs\SendShipmentNotificationJobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendShipmentNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(OrderShipped $event)
    {
        SendShipmentNotificationJobs::dispatch(); // 非同期
    }
}
