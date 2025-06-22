<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_add_payment_columns_to_transaction_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaction', function (Blueprint $table) {
            // Tanggal jatuh tempo pembayaran
            $table->timestamp('payment_due_date')->nullable()->after('method_payment');

            // Tanggal saat transaksi dilunasi
            $table->timestamp('paid_at')->nullable()->after('payment_due_date');
        });
    }

    public function down(): void
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->dropColumn(['payment_due_date', 'paid_at']);
        });
    }
};
