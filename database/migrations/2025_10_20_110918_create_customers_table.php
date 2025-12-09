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
    Schema::create('customers', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('first_name', 100);
        $table->string('last_name', 100);
        $table->string('email', 255)->unique();
        $table->string('phone', 20);
        $table->text('address')->nullable();
        $table->enum('gender', ['male', 'female'])->nullable();
        $table->text('notes')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('customers');
}

};
