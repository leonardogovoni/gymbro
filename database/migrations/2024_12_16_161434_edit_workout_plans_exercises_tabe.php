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
        Schema::table('workout_plan_exercises', function (Blueprint $table) {
            $table->smallInteger('rest')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workout_plan_exercises', function (Blueprint $table) {
            $table->decimal('rest', 5, 2)->nullable()->change();
        });
    }
};
