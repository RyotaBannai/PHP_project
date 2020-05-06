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

    public function __construct()
    {
        //
    }

    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        return new PrivateChannel('order.'.$this->update->order_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => 'PRIVATE',
        ];
   }
}
