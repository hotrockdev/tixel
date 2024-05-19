<?php

namespace App\Events;

use App\Models\OrderItems;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderItemUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order_item;

    /**
     * Create a new event instance.
     */
    public function __construct(OrderItems $order_item)
    {
        $this->order_item = $order_item;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('order-item-updated');
    }

    public function broadcastWith()
    {
        return [
            'order_item_id' => $this->order_item->id,
            'status' => $this->order_item->status,
        ];
    }
}
