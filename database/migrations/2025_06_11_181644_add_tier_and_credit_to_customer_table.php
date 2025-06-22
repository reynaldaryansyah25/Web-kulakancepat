<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_add_tier_and_credit_to_customer_table.php

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
        Schema::table('customer', function (Blueprint $table) {
            // PERBAIKAN DI SINI:
            // 1. Buat kolom dengan tipe data yang benar (UNSIGNED INTEGER)
            $table->unsignedInteger('customer_tier_id')
                ->nullable()
                ->after('id_sales');

            // 2. Tambahkan kolom plafon kredit
            $table->decimal('credit_limit', 15, 2)
                ->default(0)
                ->after('customer_tier_id');

            // 3. Definisikan foreign key secara eksplisit dengan nama kolom yang benar
            $table->foreign('customer_tier_id')
                ->references('id_customer_tier') // <-- Referensikan ke 'id_customer_tier'
                ->on('customer_tiers')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu sebelum menghapus kolom
            $table->dropForeign(['customer_tier_id']);
            $table->dropColumn(['customer_tier_id', 'credit_limit']);
        });
    }
};
