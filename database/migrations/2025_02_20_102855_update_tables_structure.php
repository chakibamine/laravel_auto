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
        Schema::table('dossier', function (Blueprint $table) {
            $table->dropColumn('n_serie');
        });

        Schema::table('dossier', function (Blueprint $table) {
            $table->string('n_serie')->nullable()->after('resultat');
        });

        Schema::table('reg', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->after('dossier_id');
            $table->dropColumn('prix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossier', function (Blueprint $table) {
            $table->dropColumn('n_serie');
        });

        Schema::table('dossier', function (Blueprint $table) {
            $table->string('n_serie')->after('resultat');
        });

        Schema::table('reg', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->decimal('prix', 10, 2)->after('dossier_id');
        });
    }
};
