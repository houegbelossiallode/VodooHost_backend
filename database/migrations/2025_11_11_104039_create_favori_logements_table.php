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
        Schema::create('favori_logements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logement_id')->constrained('logements')->onDelete('cascade');
            $table->foreignId('favorite_id')->constrained('favorites')->onDelete('cascade');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favori_logements');
    }
};
