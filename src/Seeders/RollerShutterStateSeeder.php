<?php
namespace Tchoblond59\SSRollerShutter\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RollerShutterStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roller_shutter_states')->insert([
            'name' => 'Volet fermé',
            'image' => 'https://cdn2.iconfinder.com/data/icons/window-blinds-shades-glyph/64/04_blinds-roller-garage-shutters-512.png',
            'message_type' => 30,
        ]);

        DB::table('roller_shutter_states')->insert([
            'name' => 'Volet ouvert',
            'image' => 'https://cdn2.iconfinder.com/data/icons/window-blinds-shades-glyph/64/04_blinds-roller-garage-shutters-512.png',
            'message_type' => 29,
        ]);

        DB::table('roller_shutter_states')->insert([
            'name' => 'Etat inconnu',
            'image' => 'https://cdn2.iconfinder.com/data/icons/window-blinds-shades-glyph/64/04_blinds-roller-garage-shutters-512.png',
            'message_type' => 31,
        ]);
    }
}
