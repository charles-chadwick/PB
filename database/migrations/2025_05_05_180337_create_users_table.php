<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up() : void {
		Schema::create('users', function ( Blueprint $table ) {
			$table->id();
			$table->string('role');
			$table->string('first_name');
			$table->string('middle_name')
				  ->nullable();
			$table->string('last_name');
			$table->string('email');
			$table->string('password');
			$table->timestamp('email_verified_at')
				  ->nullable();
			$table->string('remember_token', 100)
				  ->nullable();
			$table->unsignedBigInteger('created_by_id');
			$table->unsignedBigInteger('updated_by_id')
				  ->nullable();
			$table->unsignedBigInteger('deleted_by_id')
				  ->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down() : void {
		Schema::dropIfExists('users');
	}
};
