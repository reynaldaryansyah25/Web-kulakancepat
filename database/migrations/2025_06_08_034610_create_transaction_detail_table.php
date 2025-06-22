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
        Schema::create('transaction_detail', function (Blueprint $table) {
            $table->increments('id_detail_transaction');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->unsignedInteger('id_product')->nullable();
            $table->unsignedInteger('id_transaction')->nullable();
            // No default Laravel timestamps

            $table->foreign('id_product')
                ->references('id_product')
                ->on('products') // Pastikan tabel 'products' sudah ada
                ->onDelete('set null');

            $table->foreign('id_transaction')
                ->references('id_transaction')
                ->on('transaction') // Pastikan tabel 'transaction' sudah ada
                ->onDelete('cascade'); // Jika transaksi dihapus, detailnya ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_detail');
    }
};
