<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GymCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('workout_plans')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'Scheda Principiante',
                'description' => 'Placeholder',
                'start' => '07/12/2024',
                'end' => '07/12/2025',
                'enabled' => true,
            ],
        ]);

        DB::table('workout_plan_exercises')->insert([
            // Giorno 1
            [
                'workout_plan_id' => 1,
                'exercise_id' => 2,
                'day' => 1,
                'sequence' => 1,
                'series' => 4,
                'repetitions' => 12,
                'rest' => 1.30,
            ],
            [
                'workout_plan_id' => 1,
                'exercise_id' => 1,
                'day' => 1,
                'sequence' => 2,
                'series' => 4,
                'repetitions' => 15,
                'rest' => 1.30,
            ],
            [
                'workout_plan_id' => 1,
                'exercise_id' => 4,
                'day' => 1,
                'sequence' => 3,
                'series' => 4,
                'repetitions' => 12,
                'rest' => 1.30,
            ],
            // Giorno 2
            [
                'workout_plan_id' => 1,
                'exercise_id' => 6,
                'day' => 2,
                'sequence' => 1,
                'series' => 4,
                'repetitions' => 12,
                'rest' => 1.30,
            ],
        ]);
    }
}
