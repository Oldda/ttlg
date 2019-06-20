<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserBrowseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $user_id2;
    public $user_id3;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Int $user_id,Int $id2,Int $id3)
    {
        $this->user_id = $user_id;
        $this->user_id2 = $id2;
        $this->user_id3 = $id3;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
