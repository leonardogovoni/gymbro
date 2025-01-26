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
		Schema::table('users', function (Blueprint $table) {
			$table->renameColumn('name', 'first_name');
			$table->string('last_name')->after('first_name')->nullable();
			$table->boolean('is_gym')->default(false)->after('is_admin');
			$table->unsignedBigInteger('controlled_by')->after('is_gym')->nullable();

			$table->foreign('controlled_by')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->renameColumn('first_name', 'name');
			$table->dropColumn('last_name');
			$table->dropColumn('is_gym');
			$table->dropColumn('controlled_by');
		});
	}
};
