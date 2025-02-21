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
            $table->decimal('price', 10, 2);
            $table->string('ref', 6);
            $table->boolean('status')->default(1);
            $table->boolean('resultat')->default(0);
            $table->string('n_serie', 50)->nullable();
            $table->timestamp('date_inscription')->nullable();
            $table->timestamp('date_cloture')->nullable();
            $table->string('insert_user', 50);
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
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