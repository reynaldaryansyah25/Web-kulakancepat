<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_system_recommendation_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_recommendation_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('customer_id');

            $table->string('type');
            $table->text('message');
            $table->timestamp('sent_at')->useCurrent();
            $table->json('metadata')->nullable();

            // Definisi foreign key constraint secara terpisah
            $table->foreign('customer_id')
                ->references('id_customer') // Mereferensikan kolom 'id_customer'
                ->on('customer')           // di tabel 'customer'
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_recommendation_logs');
    }
};
