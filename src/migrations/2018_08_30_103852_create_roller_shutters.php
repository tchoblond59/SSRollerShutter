<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRollerShutters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roller_shutter_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roller_shutter_state_id')->unsigned();
            $table->integer('sensor_id')->unsigned();
            $table->timestamps();

            $table->foreign('roller_shutter_state_id')->references('id')->on('roller_shutter_states');
            $table->foreign('sensor_id')->references('id')->on('sensors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roller_shutter_configs');
    }
}
