<?php

namespace Tchoblond59\SSRollerShutter\Models;

use Illuminate\Database\Eloquent\Model;

class RollerShutterState extends Model
{
    public function config()
    {
        return $this->hasMany('\Tchoblond59\SSRollerShutter\Models\RollerShutterConfig', 'roller_shutter_state_id');
    }
}
