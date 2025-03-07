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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_id')->constrained('healths')->onDelete('cascade'); // lien avec la table health
            $table->string('name'); // Nom du médicament
            $table->string('dosage'); // Dosage du médicament
            $table->text('note')->nullable(); // Note éventuelle
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
