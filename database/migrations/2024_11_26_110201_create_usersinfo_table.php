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
        Schema::create('usersinfo', function (Blueprint $table) {
            $table->id(); // Campo IDENTITY(1,1), equivalente a un id autoincrementale
            $table->unsignedBigInteger('user_id')->nullable(); // int NULL, chiave esterna verso utenti
            $table->smallInteger('age')->nullable(); // smallint NULL
            $table->decimal('height', 2, 2)->nullable(); // decimal(2, 2) NULL
            $table->decimal('weight', 3, 1)->nullable(); // decimal(3, 1) NULL
            $table->decimal('lean_mass', 3, 1)->nullable(); // decimal(3, 1) NULL
            $table->decimal('fat_mass', 3, 1)->nullable(); // decimal(3, 1) NULL
            $table->string('notes', 100)->nullable(); // nvarchar(100) NULL
            $table->date('date')->nullable(); // date NULL
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
        Schema::dropIfExists('usersinfo');
    }
};
