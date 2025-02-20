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
        Schema::table('dossier', function (Blueprint $table) {
            $table->string('n_serie_new')->nullable()->after('resultat');
        });

        // Copy data from old column to new column
        DB::statement('UPDATE dossier SET n_serie_new = n_serie');

        Schema::table('dossier', function (Blueprint $table) {
            $table->dropColumn('n_serie');
        });

        Schema::table('dossier', function (Blueprint $table) {
            $table->renameColumn('n_serie_new', 'n_serie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossier', function (Blueprint $table) {
            $table->string('n_serie_old')->after('resultat');
        });

        // Copy data back
        DB::statement('UPDATE dossier SET n_serie_old = n_serie');

        Schema::table('dossier', function (Blueprint $table) {
            $table->dropColumn('n_serie');
        });

        Schema::table('dossier', function (Blueprint $table) {
            $table->renameColumn('n_serie_old', 'n_serie');
        });
    }
};
