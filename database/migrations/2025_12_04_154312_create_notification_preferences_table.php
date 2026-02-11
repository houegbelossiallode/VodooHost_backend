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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Types de notifications générales
            $table->boolean('email')->default(true);
            $table->boolean('sms')->default(true);
            $table->boolean('in_app')->default(true);
            // Notifications spécifiques du système
            $table->boolean('reservation_confirmee')->default(true);
            $table->boolean('annulation_reservation')->default(true);
            $table->boolean('nouveau_message')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
