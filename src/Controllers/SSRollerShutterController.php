<?php

namespace Tchoblond59\SSRollerShutter\Controllers;

use App\Command;
use App\Http\Controllers\Controller;
use App\Message;
use App\MSCommand;
use App\Sensor;
use App\SensorFactory;
use App\Widget;
use Illuminate\Http\Request;
use Tchoblond59\SSRollerShutter\Models\SSRollerShutter;

class SSRollerShutterController extends Controller
{
    public function open(Request $request)
    {
        $this->validate($request, [
            'widget' => 'required|exists:widgets,id',
            'sensor' => 'required|exists:sensors,id',
        ]);
        $sensor = Sensor::find($request->sensor);
        $roller_shutter = SensorFactory::create($sensor->classname, $sensor->id);
        $roller_shutter->open();
        return json_encode('ok');
    }

    public function close(Request $request)
    {
        $this->validate($request, [
            'widget' => 'required|exists:widgets,id',
            'sensor' => 'required|exists:sensors,id',
        ]);
        $sensor = Sensor::find($request->sensor);
        $roller_shutter = SensorFactory::create($sensor->classname, $sensor->id);
        $roller_shutter->close();
        return json_encode('ok');
    }

    public function stop(Request $request)
    {
        $this->validate($request, [
            'widget' => 'required|exists:widgets,id',
            'sensor' => 'required|exists:sensors,id',
        ]);
        $sensor = Sensor::find($request->sensor);
        $roller_shutter = SensorFactory::create($sensor->classname, $sensor->id);
        $roller_shutter->stop();
        return json_encode('ok');
    }

    public function config($id)
    {
        $widget = Widget::findOrFail($id);
        $sensor = $widget->sensor;
        $last_current = Message::where('node_address', $sensor->node_address)
            ->where('sensor_address', '6')
            ->where('type', '17')
            ->orderBy('created_at', 'desc')
            ->first();
        $last_temp = Message::where('node_address', $sensor->node_address)
            ->where('sensor_address', '3')
            ->where('type', '0')
            ->orderBy('created_at', 'desc')
            ->first();

        if(!$last_current)
        {
            $current = '?';
        }
        else
        {
            $current = $last_current->value;
        }

        if(!$last_temp)
        {
            $temp = '?';
        }
        else
        {
            $temp = $last_temp->value;
        }
        return view('ssrollershutter::config')->with([
            'last_current' => $current,
            'last_temp' => $temp,
            'sensor' => $sensor,
            'widget' => $widget,
        ]);
    }

    public function calibrate($id)
    {
        $sensor = Sensor::find($id);
        $roller_shutter = SensorFactory::create($sensor->classname, $sensor->id);
        $roller_shutter->calibrate();
        return redirect()->back();
    }

    public function setPercent($id, Request $request)
    {
        $this->validate($request, [
            'percent' => 'required|numeric|min:0|max:100',
        ]);
        $sensor = Sensor::find($id);
        $roller_shutter = SensorFactory::create($sensor->classname, $sensor->id);
        $roller_shutter->setValue($request->percent);
        return json_encode('ok');
    }

    public function endStop($id)
    {
        $sensor = Sensor::find($id);
        $roller_shutter = SensorFactory::create($sensor->classname, $sensor->id);
        $roller_shutter->endStop();
        return redirect()->back();
    }

    public function addCommande($id, Request $request)
    {
        $this->validate($request, [
            'nom' => 'required',
            'commande' => 'required',
        ]);
        $sensor = Sensor::findOrFail($id);
        $commande = new MSCommand();
        $commande->name = $request->nom;
        $commande->sensor_id = $sensor->id;
        $commande->command = 1;//SET
        $commande->ack = 1;
        $commande->type = $request->commande;//29 V_UP | 30 V_DOWN
        $commande->payload = 0;
        $commande->save();

        $command = new Command();
        $command->name = $commande->name;
        $command->commandable_id = $commande->id;
        $command->commandable_type = 'App\MSCommand';
        $command->save();

        return redirect()->back();
    }
}
