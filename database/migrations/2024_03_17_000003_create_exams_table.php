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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->date('date_exam');
            $table->string('type_exam', 25);
            $table->string('n_serie', 50)->nullable();
            $table->enum('resultat', ['0', '1', '2'])->default('0');
            $table->foreignId('dossier_id')->constrained('dossier')->onDelete('cascade');
            $table->timestamps();
            $table->string('insert_user', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
}; 