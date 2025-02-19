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
            $table->string('firstname_ar', 50)->nullable()->after('firstname');
            $table->string('lastname_ar', 50)->nullable()->after('lastname');
            $table->string('place_birth_ar', 50)->nullable()->after('place_birth');
            $table->string('address_ar', 50)->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            $table->dropColumn([
                'firstname_ar',
                'lastname_ar',
                'place_birth_ar',
                'address_ar'
            ]);
        });
    }
};
