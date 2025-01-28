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
		Schema::create('workout_plan_exercises', function (Blueprint $table) {
			$table->id();
			// Relazione N:M
			$table->unsignedBigInteger('workout_plan_id');
			$table->unsignedBigInteger('exercise_id');
			$table->unsignedSmallInteger('day');
			// Posizione dell'esercizio all'interno della giornata
			$table->unsignedSmallInteger('order');
			$table->unsignedSmallInteger('sets');
			// Definita stringa, se le ripetizioni cambiano per ogni
			// serie viene formattata come "10-8-6" es.
			$table->string('reps', 100);
			$table->unsignedSmallInteger('rest');
			$table->boolean('edited')->default(true);
			$table->timestamps();

			//  Chiavi esterne
			$table->foreign('workout_plan_id')->references('id')->on('workout_plans')->onDelete('cascade');
			$table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('workout_plan_exercises');
	}
};
