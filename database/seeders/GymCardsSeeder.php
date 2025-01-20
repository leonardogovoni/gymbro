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
                'enabled' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('workout_plan_exercises')->insert([
            // Giorno 1
            [
                'workout_plan_id' => 1,
                'exercise_id' => 2,
                'day' => 1,
                'order' => 1,
                'sets' => 4,
                'reps' => 12,
                'rest' => 90,
            ],
            [
                'workout_plan_id' => 1,
                'exercise_id' => 1,
                'day' => 1,
                'order' => 2,
                'sets' => 4,
                'reps ' => 15,
                'rest' => 90,
            ],
            [
                'workout_plan_id' => 1,
                'exercise_id' => 4,
                'day' => 1,
                'order' => 3,
                'sets' => 4,
                'reps ' => 12,
                'rest' => 90,
            ],
            // Giorno 2
            [
                'workout_plan_id' => 1,
                'exercise_id' => 6,
                'day' => 2,
                'order' => 1,
                'sets' => 4,
                'reps ' => 12,
                'rest' => 90,
            ],
        ]);
    }
}
