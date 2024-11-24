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
        Schema::create('utenti', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->string('nome', 50)->nullable(); // nvarchar(50) NULL
            $table->string('cognome', 50)->nullable(); // nvarchar(50) NULL
            $table->string('cf', 50)->nullable(); // nvarchar(50) NULL
            $table->char('sesso', 1)->nullable(); // char(1) NULL
            $table->date('data_di_nascita')->nullable(); // date NULL
            $table->integer('scheda')->nullable(); // int NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utenti');
    }
};
