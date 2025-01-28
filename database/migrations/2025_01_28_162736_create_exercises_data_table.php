<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('exercises_data', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('exercise_id');
			$table->unsignedBigInteger('workout_plan_id')->nullable();
			$table->unsignedBigInteger('workout_plan_pivot_id')->nullable();
			// Sarebbe il numero del set in tale esericizio,
			// ma se mettiamo set si incasina con l'ORM
			$table->unsignedSmallInteger('day');
			$table->unsignedInteger('set');
			$table->unsignedInteger('reps');
			$table->decimal('used_weights', 6, 2);
			$table->timestamps();

			// Chiavi esterne
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
			$table->foreign('workout_plan_id')->references('id')->on('workout_plans')->onDelete('set null');
			$table->foreign('workout_plan_pivot_id')->references('id')->on('workout_plan_exercises')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('exercises_data');
	}
};
