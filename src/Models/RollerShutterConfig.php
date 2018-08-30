<?php

namespace Tchoblond59\SSRollerShutter\Models;

use Illuminate\Database\Eloquent\Model;

class RollerShutterConfig extends Model
{
    protected $fillable = ['roller_shutter_state_id', 'sensor_id'];

    public function state()
    {
        return $this->belongsTo('\Tchoblond59\SSRollerShutter\Models\RollerShutterState', 'roller_shutter_state_id');
    }
}
