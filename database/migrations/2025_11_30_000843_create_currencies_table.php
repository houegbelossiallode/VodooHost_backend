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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();       // XOF, EUR, USD...
            $table->string('name');                     // Franc CFA UEMOA, Euro...
            $table->string('symbol', 5)->nullable();    // F CFA, €, $
            $table->decimal('rate_from_xof', 12, 8);    // combien vaut 1 XOF dans cette devise
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
