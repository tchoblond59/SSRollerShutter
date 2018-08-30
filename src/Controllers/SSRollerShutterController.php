<?php

namespace Tchoblond59\SSRollerShutter\Controllers;

use App\Http\Controllers\Controller;
use App\Sensor;
use App\SensorFactory;
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
}
