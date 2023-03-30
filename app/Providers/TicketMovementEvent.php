<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketMovementEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $userId;
    public $type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $notificationReceiver, $type = null)
    {
        $this->message = $message;
        $this->userId = $notificationReceiver->id;
        $this->type = $type;
        info($message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // In term of Handover and Backward We don't need to think about userId
        
        return ($this->type == 'forward' && auth()->user()->id == $this->userId)
        ? null
        : new PrivateChannel('App.Models.User.'.$this->userId);

    }

    public function broadcastAs()
    {
        return 'ticket-movement-event';
    }
}
