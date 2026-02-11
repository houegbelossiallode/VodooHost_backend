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
        Schema::create('pointfort_quartier', function (Blueprint $table) {
            $table->id();
             $table->foreignId('quartier_id')
                ->constrained('quartiers')
                ->cascadeOnDelete();
            $table->foreignId('pointfort_id')
                ->constrained('pointforts')
                ->cascadeOnDelete();
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointfort_quartier');
    }
};
