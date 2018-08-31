<?php

namespace Tchoblond59\SSRollerShutter\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tchoblond59\SSRollerShutter\Events\SSRollerShutterEvent;
use Tchoblond59\SSRollerShutter\Models\RollerShutterState;
use Tchoblond59\SSRollerShutter\Models\SSRollerShutter;
use App\Events\MSMessageEvent;

class SSRollerShutterListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MSMessageEvent  $event
     * @return void
     */
    public function handle(MSMessageEvent $event)
    {
        $sensor = SSRollerShutter::where('node_address', '=', $event->message->getNodeId())->where('classname', '=', '\Tchoblond59\SSRollerShutter\Models\SSRollerShutter')->first();
        if($sensor)
        {
            \Log::useFiles(storage_path('/logs/ssrollershutter.log'), 'info');
            \Log::info('Roller Shutter message type '.$event->message->getType());
            $state = RollerShutterState::where('message_type', $event->message->getType())->first();
            \Log::info('Roller Shutter message type '.$event->message->getType());
            if($state)
            {
                $config = $sensor->config;
                //$config->state->save($state);
                $config->roller_shutter_state_id = $state->id;
                $config->save();

                $event = new SSRollerShutterEvent($sensor, $sensor->config, $sensor->config->state);
                event($event);
                \Log::info('Throw event');
            }
        }
    }
}
