<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use App\Models\Flight;

class OrderShipped
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public function __construct()
    {

    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
