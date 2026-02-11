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
        Schema::table('retraits', function (Blueprint $table) {
            $table->string('methode')->after('montant')->nullable();
            $table->string('numero_compte')->after('methode')->nullable();
            $table->string('nom_titulaire')->after('numero_compte')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retraits', function (Blueprint $table) {
            //
        });
    }
};
