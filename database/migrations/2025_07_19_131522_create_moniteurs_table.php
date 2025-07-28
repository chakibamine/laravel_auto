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
        Schema::create('moniteurs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cin');
            $table->string('n_permit');
            $table->string('categorie_permit');
            $table->string('n_carte_moniteur');
            $table->string('categorie_carte_moniteur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moniteurs');
    }
};
