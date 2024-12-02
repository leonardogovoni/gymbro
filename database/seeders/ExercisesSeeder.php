<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ExercisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercises')->insert([
            [
                'name' => 'Leg Extension',
                'image' => 'leg_extension.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'name' => 'Pressa 45°',
                'image' => 'pressa_45.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'name' => 'Hack Squat',
                'image' => 'hack_squat.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'name' => 'Leg Curl',
                'image' => 'leg_curl.png',
                'description' => 'Placeholder',
                'muscle' => 'ischio-crurali',
            ],
            [
                'name' => 'Leg Curl Seduto',
                'image' => 'leg_curl_seduto.png',
                'description' => 'Placeholder',
                'muscle' => 'ischio-crurali',
            ],
            [
                'name' => 'Calf Machine In Piedi',
                'image' => 'calf_machine.png',
                'description' => 'Placeholder',
                'muscle' => 'Polpacci',
            ],
        ]);
    }
}