<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up() : void {
		Schema::disableForeignKeyConstraints();

		Schema::create('profiles', function ( Blueprint $table ) {
			$table->id();
			$table->integer('patient_id');
			$table->date('dob');
			$table->string('gender');
			$table->unsignedBigInteger('created_by_id');
			$table->unsignedBigInteger('updated_by_id')
				  ->nullable();
			$table->unsignedBigInteger('deleted_by_id')
				  ->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::enableForeignKeyConstraints();
	}

	/**
	 * Reverse the migrations.
	 */
	public function down() : void {
		Schema::dropIfExists('profiles');
	}
};
