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
			$table->string('name', 50);
			$table->string('image', 100)->nullable();
			$table->string('description', 200)->nullable();
			$table->string('muscle', 50);
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
