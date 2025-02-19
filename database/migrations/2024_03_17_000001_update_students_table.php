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
        Schema::table('student', function (Blueprint $table) {
            // Check and add columns if they don't exist
            if (!Schema::hasColumn('student', 'firstname')) {
                $table->string('firstname', 50)->nullable();
            }
            if (!Schema::hasColumn('student', 'lastname')) {
                $table->string('lastname', 50)->nullable();
            }
            if (!Schema::hasColumn('student', 'gender')) {
                $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            }
            if (!Schema::hasColumn('student', 'cin')) {
                $table->string('cin', 10)->nullable();
            }
            if (!Schema::hasColumn('student', 'date_birth')) {
                $table->date('date_birth')->nullable();
            }
            if (!Schema::hasColumn('student', 'place_birth')) {
                $table->string('place_birth', 50)->nullable();
            }
            if (!Schema::hasColumn('student', 'address')) {
                $table->string('address', 50)->nullable();
            }
            if (!Schema::hasColumn('student', 'city')) {
                $table->string('city', 30)->nullable();
            }
            if (!Schema::hasColumn('student', 'phone')) {
                $table->string('phone', 10)->nullable();
            }
            if (!Schema::hasColumn('student', 'a_firstname')) {
                $table->string('a_firstname', 30)->nullable();
            }
            if (!Schema::hasColumn('student', 'a_lastname')) {
                $table->string('a_lastname', 30)->nullable();
            }
            if (!Schema::hasColumn('student', 'a_place_birth')) {
                $table->string('a_place_birth', 50)->nullable();
            }
            if (!Schema::hasColumn('student', 'a_address')) {
                $table->string('a_address', 50)->nullable();
            }
            if (!Schema::hasColumn('student', 'reg_date')) {
                $table->timestamp('reg_date')->nullable();
            }
            if (!Schema::hasColumn('student', 'insert_user')) {
                $table->string('insert_user', 50)->nullable();
            }
            if (!Schema::hasColumn('student', 'image_url')) {
                $table->text('image_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Since this is an update migration, we don't want to drop columns in rollback
        // as it might affect existing data
    }
}; 