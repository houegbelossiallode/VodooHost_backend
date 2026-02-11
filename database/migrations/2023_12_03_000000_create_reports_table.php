<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            // Utilisateur qui signale le problème
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Lien de l'annonce (URL complète)
            $table->string('annonce_url')->nullable();
            // Type de problème (annonce, paiement, réservation, bug, autre...)
            $table->string('type', 100)->nullable();
            // Message détaillé du visiteur
            $table->text('message');
            // Statut de traitement : nouveau, en_cours, resolu, clos...
            $table->string('status', 50)->default('nouveau');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
