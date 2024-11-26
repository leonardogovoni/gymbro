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
        Schema::create('exercisesdata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // int NULL, chiave esterna verso utenti
            $table->unsignedBigInteger('exercise_id')->nullable(); // int NULL, chiave esterna verso esercizi
            $table->integer('set')->nullable(); // int NULL
            $table->decimal('used_kg', 3, 2)->nullable(); // decimal(3,2) NULL
            $table->date('date')->nullable(); // date NULL
            $table->timestamps();

            // Chiavi esterne
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercisesdata');
    }
};
