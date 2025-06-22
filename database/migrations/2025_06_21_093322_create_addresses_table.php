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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('id_address');

            // DIPERBAIKI: Tipe data diubah menjadi unsignedInteger agar cocok dengan primary key di tabel 'customer'.
            $table->unsignedInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customer')->onDelete('cascade');

            $table->string('label'); // Contoh: Rumah, Kantor, Toko
            $table->string('recipient_name');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('notes')->nullable();
            
            // Kolom untuk pinpoint map (opsional)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Kolom untuk menandai alamat utama
            $table->boolean('is_primary')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
