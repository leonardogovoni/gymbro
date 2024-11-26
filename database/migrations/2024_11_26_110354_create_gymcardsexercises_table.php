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
        Schema::create('gymcardsexercises', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->unsignedBigInteger('gymcard_id')->nullable(); // int NULL
            $table->unsignedBigInteger('exercise_id')->nullable(); // int NULL
            $table->smallInteger('day')->nullable(); // smallint NULL
            $table->smallInteger('sequence')->nullable(); // smallint NULL
            $table->smallInteger('series')->nullable(); // smallint NULL
            $table->string('repetitions', 10)->nullable(); // nvarchar(10) NULL
            $table->decimal('rest', 5, 2)->nullable(); // decimal(5, 2) NULL
            $table->timestamps();

            // Chiavi esterne
            $table->foreign('gymcard_id')->references('id')->on('gymcards')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gymcardsexercises');
    }
};
