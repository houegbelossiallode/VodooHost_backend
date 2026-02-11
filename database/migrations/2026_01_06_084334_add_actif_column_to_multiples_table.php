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
        Schema::table('comptes', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('constances', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('divinite_logement', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('sousmenus', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('role_permissions', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('equipement_logement', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('logement_dejeuner', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('logement_disponibilites', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('quartiers', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('reglements', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

        Schema::table('rituel_logement', function (Blueprint $table) {
            $table->string('actif')->default('OUI');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comptes', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('constances', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('divinite_logement', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('sousmenus', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('equipement_logement', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('logement_dejeuner', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('logement_disponibilites', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('quartiers', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('reglements', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

        Schema::table('rituel_logement', function (Blueprint $table) {
            $table->dropColumn('actif');
        });

    }
};
