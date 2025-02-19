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
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('gender', 10);
            $table->string('cin', 10);
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->date('date_birth');
            $table->string('place_birth', 50);
            $table->string('address', 50);
            $table->string('city', 30);
            $table->string('phone', 10);
            
            // Guardian Information
            $table->string('a_firstname', 30);
            $table->string('a_lastname', 30);
            $table->string('a_place_birth', 50);
            $table->string('a_address', 50);
            
            // System Fields
            $table->timestamp('reg_date')->nullable();
            $table->string('insert_user', 50)->nullable();
            $table->text('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
}; 