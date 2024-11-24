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
        Schema::create('datiesercizi', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->unsignedBigInteger('id_utente')->nullable(); // int NULL, chiave esterna verso utenti
            $table->unsignedBigInteger('id_esercizio')->nullable(); // int NULL, chiave esterna verso esercizi
            $table->integer('serie')->nullable(); // int NULL
            $table->decimal('kg_usati', 3, 2)->nullable(); // decimal(3,2) NULL
            $table->date('data')->nullable(); // date NULL

            // Chiavi esterne
            $table->foreign('id_utente')->references('id')->on('utenti')->onDelete('cascade');
            $table->foreign('id_esercizio')->references('id')->on('esercizi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datiesercizi');
    }
};
