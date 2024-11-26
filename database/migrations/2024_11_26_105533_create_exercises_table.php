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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable(); // nvarchar(50) NULL
            $table->string('image', 50)->nullable(); // nvarchar(50) NULL
            $table->string('description', 100)->nullable(); // nvarchar(100) NULL
            $table->string('muscle', 50)->nullable(); // nvarchar(50) NULL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
