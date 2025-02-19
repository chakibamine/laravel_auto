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
        Schema::create('reg', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_reg');
            $table->integer('prix');
            $table->string('motif', 50);
            $table->timestamp('date_insertion');
            $table->string('nom_du_payeur', 75);
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
        Schema::dropIfExists('reg');
    }
};
