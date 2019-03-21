<?php

namespace Tchoblond59\SSRollerShutter\Models;

use App\Mqtt\MqttSender;
use App\Mqtt\MSMessage;
use App\Sensor;
use Illuminate\Support\Facades\Artisan;

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
        return ['css/tchoblond59/ssrollershutter/ssrollershutter.css'];
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
    }

    public function close()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_DOWN',1);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
    }

    public function stop()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_STOP',1);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
    }

    public function calibrate()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, 2, 'V_STATUS',1);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
    }

    public function endStop()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, 4, 'V_STATUS',1);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
    }

    public function setValue($value)
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_PERCENTAGE',1);
        $message->setMessage($value);
        MqttSender::sendMessage($message);
        /*$event = new LaraLightEvent($this, $level, $config);
        event($event);*/
    }

    public function onEnable()
    {
        Artisan::call('db:seed', ['--class' => 'Tchoblond59\SSRollerShutter\Seeders\RollerShutterStateSeeder']);
    }
}