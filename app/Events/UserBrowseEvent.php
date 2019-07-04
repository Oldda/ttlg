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

    public $imei;
    public $browse_page;
    public $browse_info;
    public $request_url;
    public $operating_system;
    public $phone_type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($imei,$browse_page,$browse_info,$request_url,$operating_system,$phone_type)
    {
        $this->imei = $imei;
        $this->browse_page = $browse_page;
        $this->browse_info = $browse_info;
        $this->request_url = $request_url;
        $this->operating_system = $operating_system;
        $this->phone_type = $phone_type;
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
