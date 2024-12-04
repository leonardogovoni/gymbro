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
                'id' => 1,
                'name' => 'Leg Extension',
                'image' => 'leg_extension.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'id' => 2,
                'name' => 'Pressa 45°',
                'image' => 'pressa_45.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'id' => 3,
                'name' => 'Hack Squat',
                'image' => 'hack_squat.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'id' => 4,
                'name' => 'Leg Curl',
                'image' => 'leg_curl.png',
                'description' => 'Placeholder',
                'muscle' => 'ischio-crurali',
            ],
            [
                'id' => 5,
                'name' => 'Leg Curl Seduto',
                'image' => 'leg_curl_seduto.png',
                'description' => 'Placeholder',
                'muscle' => 'ischio-crurali',
            ],
            [
                'id' => 6,
                'name' => 'Calf Machine In Piedi',
                'image' => 'calf_machine.png',
                'description' => 'Placeholder',
                'muscle' => 'Polpacci',
            ],
        ]);
    }
}