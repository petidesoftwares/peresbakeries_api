<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductsNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(string $product, string $message )
    {
        $this->product = $product;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('products'),
        ];
    }

    public function broadcastAs(){
        return 'ProductsNotificationEvent';
    }
}
