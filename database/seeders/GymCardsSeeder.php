<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'user_id' => 1,
                'title' => 'Gambe Gambose',
                'description' => 'Placeholder',
                'start' => '07/12/2024',
                'end' => '07/12/2025',
                'enabled' => true,
            ],
        ]);
    }
}
