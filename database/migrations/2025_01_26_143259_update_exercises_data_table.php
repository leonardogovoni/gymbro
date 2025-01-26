<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exercises_data', function (Blueprint $table) {
            // Rimuove la foreign key esistente
            $table->dropForeign(['workout_plan_pivot_id']); 

            // Modifica la colonna esistente per renderla nullable
            $table->unsignedBigInteger('workout_plan_pivot_id')->nullable()->change();

            // Creo la colonna day dopo workout_plan_pivot_id
            $table->unsignedSmallInteger('day')->after('workout_plan_pivot_id');

            // Aggiungo la foreign key con onDelete set null
            $table->foreign('workout_plan_pivot_id')
                ->references('id')
                ->on('workout_plans')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises_data', function (Blueprint $table) {
            $table->dropForeign(['workout_plan_pivot_id']);

            $table->unsignedBigInteger('workout_plan_pivot_id')->change();

            $table->dropColumn('day');

            $table->foreign('workout_plan_pivot_id')
            ->references('id')
            ->on('workout_plan_exercises')
            ->onDelete('cascade');
        });
    }
};
