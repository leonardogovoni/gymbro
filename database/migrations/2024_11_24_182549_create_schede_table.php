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
        Schema::create('schede', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->unsignedBigInteger('id_utente')->nullable(); // int NULL, chiave esterna verso utenti
            $table->string('titolo', 50)->nullable(); // nvarchar(50) NULL
            $table->string('descrizione', 100)->nullable(); // nvarchar(100) NULL
            $table->date('inizio')->nullable(); // date NULL
            $table->date('fine')->nullable(); // date NULL
            $table->boolean('abilitata')->nullable(); // bit NULL

            // Chiavi esterne
            $table->foreign('id_utente')->references('id')->on('utenti')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schede');
    }
};
