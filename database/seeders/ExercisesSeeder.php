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
                'image' => 'legextension.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'name' => 'Pressa 45°',
                'image' => 'pressa45.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'name' => 'Hack Squat',
                'image' => 'hacksquat.png',
                'description' => 'Placeholder',
                'muscle' => 'Quadricipiti',
            ],
            [
                'name' => 'Leg Curl',
                'image' => 'legcurl.png',
                'description' => 'Placeholder',
                'muscle' => 'ischio-crurali',
            ],
            [
                'name' => 'Leg Curl Seduto',
                'image' => 'legcurlseduto.png',
                'description' => 'Placeholder',
                'muscle' => 'ischio-crurali',
            ],
            [
                'name' => 'Calf Machine In Piedi',
                'image' => 'calfmachine.png',
                'description' => 'Placeholder',
                'muscle' => 'Polpacci',
            ],
        ]);
    }
}