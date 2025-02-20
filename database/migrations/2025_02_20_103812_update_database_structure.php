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
        // First, modify the dossier table
        if (Schema::hasColumn('dossier', 'n_serie')) {
            Schema::table('dossier', function (Blueprint $table) {
                $table->string('n_serie_new', 50)->nullable()->after('resultat');
            });

            // Copy data
            DB::statement('UPDATE dossier SET n_serie_new = n_serie');

            Schema::table('dossier', function (Blueprint $table) {
                $table->dropColumn('n_serie');
            });

            Schema::table('dossier', function (Blueprint $table) {
                $table->renameColumn('n_serie_new', 'n_serie');
            });
        }

        // Then, modify the reg table
        if (Schema::hasColumn('reg', 'prix')) {
            Schema::table('reg', function (Blueprint $table) {
                $table->decimal('price', 10, 2)->after('date_reg')->nullable();
            });

            // Copy data
            DB::statement('UPDATE reg SET price = prix');

            Schema::table('reg', function (Blueprint $table) {
                $table->dropColumn('prix');
            });

            // Make price required after data is copied
            Schema::table('reg', function (Blueprint $table) {
                $table->decimal('price', 10, 2)->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the reg table
        if (Schema::hasColumn('reg', 'price')) {
            Schema::table('reg', function (Blueprint $table) {
                $table->decimal('prix', 10, 2)->after('date_reg')->nullable();
            });

            // Copy data back
            DB::statement('UPDATE reg SET prix = price');

            Schema::table('reg', function (Blueprint $table) {
                $table->dropColumn('price');
            });

            // Make prix required after data is copied
            Schema::table('reg', function (Blueprint $table) {
                $table->decimal('prix', 10, 2)->nullable(false)->change();
            });
        }

        // Restore the dossier table
        if (Schema::hasColumn('dossier', 'n_serie')) {
            Schema::table('dossier', function (Blueprint $table) {
                $table->string('n_serie_old', 50)->nullable()->after('resultat');
            });

            // Copy data back
            DB::statement('UPDATE dossier SET n_serie_old = n_serie');

            Schema::table('dossier', function (Blueprint $table) {
                $table->dropColumn('n_serie');
            });

            Schema::table('dossier', function (Blueprint $table) {
                $table->renameColumn('n_serie_old', 'n_serie');
            });

            Schema::table('dossier', function (Blueprint $table) {
                $table->string('n_serie', 50)->nullable(false)->change();
            });
        }
    }
};
