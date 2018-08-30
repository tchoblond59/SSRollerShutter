<?php

namespace Tchoblond59\SSRollerShutter\Events;

use App\Sensor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Tchoblond59\SSRollerShutter\Models\SSRollerShutter;

class SSRollerShutterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roller_shutter;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SSRollerShutter $roller_shutter)
    {
        $this->roller_shutter = $roller_shutter;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chan-ssrollershutter');
    }
}
