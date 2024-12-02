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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->smallInteger('age')->nullable();
            $table->decimal('height', 2, 2)->nullable();
            $table->decimal('weight', 3, 1)->nullable();
            $table->decimal('lean_mass', 3, 1)->nullable();
            $table->decimal('fat_mass', 3, 1)->nullable();
            $table->string('notes', 100)->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('user_infos');
    }
};
