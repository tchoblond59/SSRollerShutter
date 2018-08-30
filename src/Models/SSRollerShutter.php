<?php

namespace Tchoblond59\SSRollerShutter\Models;

use App\Mqtt\MqttSender;
use App\Mqtt\MSMessage;
use App\Sensor;

class SSRollerShutter extends Sensor
{
    public function getWidget(\App\Widget $widget)
    {
        $sensor  = $widget->sensor;
        $status = $this->status;
        $config = $this->config;
        if(!$config)//Create first time
        {
            $config = RollerShutterConfig::create([
                'roller_shutter_state_id' => 3,
                'sensor_id' => $this->id,
            ]);
        }
        return view('ssrollershutter::widget')->with([
            'widget' => $widget,
            'sensor' => $sensor,
            'config' => $config,
        ]);
    }

    public function config()
    {
        return $this->hasOne('\Tchoblond59\SSRollerShutter\Models\RollerShutterConfig', 'sensor_id');
    }

    public function getCss()
    {
        return [];
    }

    public function getJs()
    {
        return ['js/tchoblond59/ssrollershutter/ssroller_shutter.js'];
    }

    public function getWidgetList()
    {
        return [1 => 'Relay NONC'];
    }

    public function onDelete()
    {

    }

    public function open()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_UP',1);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
        /*$event = new LaraLightEvent($this, $level, $config);
        event($event);*/
    }

    public function close()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_DOWN',1);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
        /*$event = new LaraLightEvent($this, $level, $config);
        event($event);*/
    }

    public function stop()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_STOP',1);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
        /*$event = new LaraLightEvent($this, $level, $config);
        event($event);*/
    }
}