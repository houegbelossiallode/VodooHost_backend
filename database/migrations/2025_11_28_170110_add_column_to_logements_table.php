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
        Schema::table('logements', function (Blueprint $table) {
             $table->foreignId('quartier_id')->nullable()->constrained('quartiers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logements', function (Blueprint $table) {
            $table->dropForeign(['quartier_id']);
            $table->dropColumn('quartier_id');
        });
    }
};
