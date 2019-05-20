<?php

namespace Tchoblond59\SSRollerShutter\Models;

use App\Message;
use App\Mqtt\MqttSender;
use App\Mqtt\MSMessage;
use App\Sensor;
use Illuminate\Support\Facades\Artisan;

class SSRollerShutter extends Sensor
{
    protected $appends = ['title'];

    public function getWidget(\App\Widget $widget)
    {
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
            'sensor' => $this,
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
        $message->set($this->node_address, $this->sensor_address, 'V_UP', 0);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
    }

    public function close()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_DOWN', 0);
        $message->setMessage(1);
        MqttSender::sendMessage($message);
    }

    public function stop()
    {
        $message = new MSMessage($this->id);
        $message->set($this->node_address, $this->sensor_address, 'V_STOP', 0);
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
        $message->set($this->node_address, $this->sensor_address, 'V_PERCENTAGE', 0);
        $message->setMessage($value);
        MqttSender::sendMessage($message);
        /*$event = new LaraLightEvent($this, $level, $config);
        event($event);*/
    }

    public function onEnable()
    {
        Artisan::call('db:seed', ['--class' => 'Tchoblond59\SSRollerShutter\Seeders\RollerShutterStateSeeder']);
    }

    public function getTitleAttribute()
    {
        if($this->config->percent == 0)
        {
            return 'Volet ouvert';
        }
        elseif($this->config->percent == 100)
        {
            return 'Volet fermé';
        }
        else
        {
            return 'Volet fermé à '.$this->config->percent.'%';
        }
    }

    public function getHistory()
    {
        $history = Message::where('node_address', $this->node_address)
            ->where('sensor_address', $this->sensor_address)
            ->where('type', 3)
            ->whereIn('value', [0,100])
            ->select('created_at', 'value')
            ->orderBy('created_at', 'desc')
            ->take(10)->get();
        $history = $history->reverse();
        $result[] = ['Date', 'Valeur'];
        foreach ($history as $key => $value)
        {
            $result[] = [$value->created_at->format('d/m/Y H:i'), (int)$value->value];

        }
        return json_encode($result);
    }
}