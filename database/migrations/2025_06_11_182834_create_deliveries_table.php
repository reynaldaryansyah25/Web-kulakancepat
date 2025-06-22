<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_deliveries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id(); // Primary key 'id' untuk tabel deliveries (UNSIGNED BIGINT)

            // PERBAIKAN DI SINI:
            // Buat kolom dengan tipe data yang sama persis dengan primary key yang direferensikan.
            $table->unsignedInteger('transaction_id'); // UNSIGNED INTEGER agar cocok dengan 'id_transaction'
            $table->unsignedInteger('sales_id')->nullable(); // UNSIGNED INTEGER agar cocok dengan 'id_sales'

            $table->enum('status', ['Preparing', 'On The Way', 'Delivered', 'Failed'])->default('Preparing');
            $table->timestamp('estimated_arrival')->nullable();
            $table->timestamps();

            // Definisikan foreign key constraint secara terpisah
            $table->foreign('transaction_id')
                ->references('id_transaction')
                ->on('transaction')
                ->cascadeOnDelete();

            $table->foreign('sales_id')
                ->references('id_sales')
                ->on('sales')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
