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
            $table->id();
            $table->date('date_reg');
            $table->decimal('price', 10, 2)->default(0);
            $table->string('motif', 50);
            $table->string('nom_du_payeur', 75);
            $table->timestamp('date_insertion');
            $table->string('insert_user', 50);
            $table->foreignId('dossier_id')->constrained('dossier')->onDelete('cascade');
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