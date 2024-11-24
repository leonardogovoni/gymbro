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
        Schema::create('esercizischede', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->unsignedBigInteger('id_scheda')->nullable(); // int NULL
            $table->unsignedBigInteger('id_esercizio')->nullable(); // int NULL
            $table->smallInteger('giorno')->nullable(); // smallint NULL
            $table->smallInteger('ordine')->nullable(); // smallint NULL
            $table->smallInteger('serie')->nullable(); // smallint NULL
            $table->string('ripetizioni', 10)->nullable(); // nvarchar(10) NULL
            $table->decimal('riposo', 5, 2)->nullable(); // decimal(5, 2) NULL

            // Chiavi esterne
            $table->foreign('id_scheda')->references('id')->on('schede')->onDelete('cascade');
            $table->foreign('id_esercizio')->references('id')->on('esercizi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esercizischede');
    }
};
