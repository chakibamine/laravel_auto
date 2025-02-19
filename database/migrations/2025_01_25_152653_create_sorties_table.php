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
        Schema::create('sortie', function (Blueprint $table) {
            $table->increments('id_sortie');
            $table->date('date_sortie');
            $table->string('motif', 70);
            $table->string('montant', 15);
            $table->timestamp('date_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortie');
    }
};
