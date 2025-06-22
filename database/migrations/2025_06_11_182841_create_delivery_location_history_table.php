<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_delivery_location_history_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_location_history', function (Blueprint $table) {
            $table->id();
            // Menghubungkan histori lokasi dengan pengiriman spesifik
            $table->foreignId('delivery_id')->constrained('deliveries')->cascadeOnDelete();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamp('recorded_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_location_history');
    }
};
