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
        Schema::table('pointforts', function (Blueprint $table) {
            $table->dropForeign(['logement_id']);
            $table->dropColumn('logement_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pointforts', function (Blueprint $table) {
            $table->foreignId('logement_id')->constrained('logements')->onDelete('cascade');
        });
    }
};
