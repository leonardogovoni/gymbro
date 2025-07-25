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
		Schema::create('gyms', function (Blueprint $table) {
			$table->id();
			$table->string('name', 100);
			$table->string('address', 100);
			$table->string('telephone', 20);
			$table->unsignedBigInteger('user_id')->nullable();
			$table->string('licenseType', 100);
			$table->date('licensePayment');
			$table->date('licenseExpiration');
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('gyms');
	}
};
