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
        Schema::create('infoutenti', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->unsignedBigInteger('id_utente')->nullable(); // int NULL, chiave esterna verso utenti
            $table->smallInteger('eta')->nullable(); // smallint NULL
            $table->decimal('altezza', 2, 2)->nullable(); // decimal(2, 2) NULL
            $table->decimal('peso', 3, 1)->nullable(); // decimal(3, 1) NULL
            $table->decimal('massa_magra', 3, 1)->nullable(); // decimal(3, 1) NULL
            $table->decimal('massa_grassa', 3, 1)->nullable(); // decimal(3, 1) NULL
            $table->string('note', 100)->nullable(); // nvarchar(100) NULL
            $table->date('data')->nullable(); // date NULL

            // Chiavi esterne
            $table->foreign('id_utente')->references('id')->on('utenti')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infoutenti');
    }
};
