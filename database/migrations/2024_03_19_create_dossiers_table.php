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
        Schema::create('dossier', function (Blueprint $table) {
            $table->id();
            $table->string('category', 2);
            $table->integer('price');
            $table->string('ref', 6);
            $table->timestamp('date_inscription')->nullable();
            $table->string('insert_user', 50)->nullable();
            $table->unsignedBigInteger('student_id');
            $table->boolean('status')->default(false);
            $table->boolean('resultat')->default(false);
            $table->integer('n_serie')->nullable();
            $table->timestamp('date_cloture')->nullable();
            $table->timestamps();

            $table->foreign('student_id')
                  ->references('id')
                  ->on('student')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier');
    }
}; 