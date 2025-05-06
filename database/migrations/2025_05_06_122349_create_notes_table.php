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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
			$table->string('on');
			$table->integer('on_id');
			$table->string('type');
			$table->text('content');
			$table->unsignedBigInteger('created_by_id');
			$table->unsignedBigInteger('updated_by_id')->nullable();
			$table->unsignedBigInteger('deleted_by_id')->nullable();
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
