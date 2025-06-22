<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_customer_tiers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_tiers', function (Blueprint $table) {
            // PERBAIKAN DI SINI:
            // Menggunakan increments() untuk membuat primary key dengan nama kustom
            $table->increments('id_customer_tier');

            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->decimal('min_monthly_purchase', 15, 2)->default(0);
            $table->integer('payment_term_days')->default(7);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_tiers');
    }
};
