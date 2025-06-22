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
        Schema::create('customer', function (Blueprint $table) {
            // Sesuai SQL: `id_customer` int NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->increments('id_customer');

            // Sesuai SQL: `name_store` varchar(255) NOT NULL
            $table->string('name_store');

            // Sesuai SQL: `name_owner` varchar(255) NOT NULL
            $table->string('name_owner');

            // Sesuai SQL: `email` varchar(100) NOT NULL UNIQUE
            $table->string('email', 100)->unique();

            // Sesuai SQL: `no_phone` int NOT NULL. Sebaiknya string untuk nomor telepon.
            $table->string('no_phone', 20); // Diubah ke string untuk fleksibilitas (0 di depan, +)

            // Sesuai SQL: `password` varchar(100) NOT NULL
            $table->string('password'); // Akan di-hash oleh Laravel

            // Sesuai SQL: `address` varchar(255) NOT NULL
            $table->string('address');

            // Sesuai SQL: `status` enum('PENDING_APPROVE','ACTIVE','INACTIVE') DEFAULT 'PENDING_APPROVE'
            $table->enum('status', ['PENDING_APPROVE', 'ACTIVE', 'INACTIVE'])->default('PENDING_APPROVE');

            // Sesuai SQL: `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('created')->nullable()->useCurrent();

            // Sesuai SQL: `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('updated')->nullable()->useCurrentOnUpdate();

            // Sesuai SQL: `id_sales` int DEFAULT NULL
            $table->unsignedInteger('id_sales')->nullable();

            // Definisi Foreign Key
            // Sesuai SQL: ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`id_sales`) REFERENCES `sales` (`id_sales`)
            // Kita asumsikan tabel 'sales' akan dibuat. Jika belum, migrasi ini mungkin gagal jika dijalankan sebelum 'sales'.
            // Laravel biasanya menangani urutan, tapi jika ada masalah, pastikan migrasi 'sales' dijalankan dulu.
            $table->foreign('id_sales')
                ->references('id_sales')
                ->on('sales') // Tabel 'sales' harus sudah ada
                ->onDelete('set null'); // Jika sales dihapus, id_sales di customer menjadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
