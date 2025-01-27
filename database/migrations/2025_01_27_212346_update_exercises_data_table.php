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
        Schema::table('exercises_data', function (Blueprint $table) {
            $table->renameColumn('workout_plan_pivot_id', 'workout_plan_id');

            $table->unsignedBigInteger('workout_plan_pivot_id')->nullable()->after('workout_plan_id');

            // Aggiungo la foreign key con onDelete set null
            $table->foreign('workout_plan_pivot_id')
                ->references('id')
                ->on('workout_plan_exercises')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises_data', function (Blueprint $table) {
            $table->dropColumn('workout_plan_pivot_id');
            $table->renameColumn('workout_plan_id', 'workout_plan_pivot_id');
        });
    }
};
