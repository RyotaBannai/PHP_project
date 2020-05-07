<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShippingStatusUpdated implements ShouldBroadcast //
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $update; // 発送状態更新の情報
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');

        // return ['my-channel']; // or
        return new Channel('my-channel');
    }

    public function broadcastAs()
    {
        return 'my-event';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
   }
}
