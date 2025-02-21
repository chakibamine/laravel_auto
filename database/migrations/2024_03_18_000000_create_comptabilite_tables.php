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
        Schema::create('entres', function (Blueprint $table) {
            $table->id();
            $table->date('date_entrer');
            $table->string('motif', 70);
            $table->decimal('montant', 10, 2);
            $table->timestamp('date_entry')->nullable();
            $table->string('insert_user', 50)->nullable();
        });

        Schema::create('sortie', function (Blueprint $table) {
            $table->id();
            $table->date('date_sortie');
            $table->string('motif', 70);
            $table->decimal('montant', 10, 2);
            $table->timestamp('date_entry')->nullable();
            $table->string('insert_user', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortie');
        Schema::dropIfExists('entres');
    }
}; 