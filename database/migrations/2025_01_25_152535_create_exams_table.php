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
        Schema::create('exam', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_exam');
            $table->string('type_exam', 25);
            $table->string('resultat', 1);
            $table->timestamp('date_insertion');
            $table->string('insert_user', 50);
            $table->unsignedBigInteger('dossier_id');

            $table->foreign('dossier_id')
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
        Schema::dropIfExists('exam');
    }
};
