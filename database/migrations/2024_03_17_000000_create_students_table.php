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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50)->nullable();
            $table->string('firstname_ar', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('lastname_ar', 50)->nullable();
            $table->string('cin', 10)->unique()->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('address_ar', 150)->nullable();
            $table->string('gender', 10)->default('M');
            $table->date('date_birth')->nullable();
            $table->string('place_birth', 50)->nullable();
            $table->string('place_birth_ar', 50)->nullable();
            $table->string('city', 30)->nullable();
            
            // Guardian Information
            $table->string('a_firstname', 30)->nullable();
            $table->string('a_lastname', 30)->nullable();
            $table->string('a_place_birth', 50)->nullable();
            $table->string('a_address', 50)->nullable();
            
            // System Fields
            $table->string('insert_user', 50);
            $table->timestamp('date_insertion')->nullable();
            $table->timestamp('reg_date')->nullable();
            $table->text('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}; 