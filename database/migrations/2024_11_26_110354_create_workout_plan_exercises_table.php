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
            $table->unsignedBigInteger('workout_plan_id')->nullable();
            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->smallInteger('day')->nullable();
            // Sarebbe l'ordine dell'esercizio nella scheda, ma non
            // si può chiamare order altrimenti si rompe l'ORM
            $table->smallInteger('sequence')->nullable();
            $table->smallInteger('series')->nullable();
            $table->string('repetitions', 10)->nullable();
            $table->decimal('rest', 5, 2)->nullable();
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
