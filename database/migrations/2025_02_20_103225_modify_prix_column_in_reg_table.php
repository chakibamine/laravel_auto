<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reg', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->after('dossier_id');
        });

        // Copy data from old column to new column
        DB::statement('UPDATE reg SET price = prix');

        Schema::table('reg', function (Blueprint $table) {
            $table->dropColumn('prix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reg', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->after('dossier_id');
        });

        // Copy data back
        DB::statement('UPDATE reg SET prix = price');

        Schema::table('reg', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
