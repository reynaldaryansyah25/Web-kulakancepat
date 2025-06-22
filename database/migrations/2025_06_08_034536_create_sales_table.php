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
        Schema::create('sales', function (Blueprint $table) {
            // Sesuai SQL: `id_sales` int NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->increments('id_sales');

            // Sesuai SQL: `name` varchar(255) NOT NULL
            $table->string('name');

            // Sesuai SQL: `email` varchar(100) NOT NULL UNIQUE
            $table->string('email', 100)->unique();

            // Sesuai SQL: `no_phone` int NOT NULL. Diubah ke string.
            $table->string('no_phone', 20);

            // Sesuai SQL: `password` varchar(100) NOT NULL
            $table->string('password'); // Akan di-hash

            // Sesuai SQL: `target_sales` decimal(15,2) DEFAULT '0.00'
            $table->decimal('target_sales', 15, 2)->default(0.00);

            // Sesuai SQL: `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('created')->nullable()->useCurrent();

            // Sesuai SQL: `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('updated')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
