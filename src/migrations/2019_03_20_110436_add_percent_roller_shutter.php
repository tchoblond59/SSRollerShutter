<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPercentRollerShutter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roller_shutter_configs', function (Blueprint $table) {
            $table->unsignedInteger('percent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roller_shutter_configs', function (Blueprint $table) {
            $table->dropColumn('percent');
        });
    }
}
