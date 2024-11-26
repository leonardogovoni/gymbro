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
        Schema::create('gymcards', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->unsignedBigInteger('user_id')->nullable(); // int NULL, chiave esterna verso utenti
            $table->string('title', 50)->nullable(); // nvarchar(50) NULL
            $table->string('description', 100)->nullable(); // nvarchar(100) NULL
            $table->date('start')->nullable(); // date NULL
            $table->date('end')->nullable(); // date NULL
            $table->boolean('enabled')->nullable(); // bit NULL
            $table->timestamps();

            // Chiavi esterne
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gymcards');
    }
};
