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
        Schema::create('cour', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_cour');
            $table->string('type', 50);
            $table->unsignedBigInteger('id_dossier');
            $table->timestamp('date_insertion');

            $table->foreign('id_dossier')
                  ->references('id')
                  ->on('dossier')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cour');
    }
};
