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
        Schema::create('esercizi', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->string('nome', 50)->nullable(); // nvarchar(50) NULL
            $table->string('immagine', 50)->nullable(); // nvarchar(50) NULL
            $table->string('descrizione', 100)->nullable(); // nvarchar(100) NULL
            $table->string('muscolo', 50)->nullable(); // nvarchar(50) NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esercizi');
    }
};
