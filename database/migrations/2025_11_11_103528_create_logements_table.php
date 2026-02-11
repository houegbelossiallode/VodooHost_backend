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
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('description');
            $table->string('adresse');
            $table->foreignId('pays_id')->constrained('pays')->onDelete('cascade');
            $table->decimal('prix_par_nuit',18,2);
            $table->integer('nb_chambre');
            $table->integer('nb_voyageur_max');
            $table->foreignId('type_logement_id')->constrained('type_logements')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logements');
    }
};
