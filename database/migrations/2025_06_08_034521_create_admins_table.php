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
        Schema::create('admins', function (Blueprint $table) {
            // Sesuai SQL: `id_admin` int NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->increments('id_admin');

            // Sesuai SQL: `name` varchar(255) NOT NULL
            $table->string('name');

            // Sesuai SQL: `email` varchar(100) NOT NULL UNIQUE
            $table->string('email', 100)->unique();

            // Sesuai SQL: `password` varchar(100) NOT NULL
            // Di Laravel, panjang default string adalah 255, jadi kita tidak perlu menentukan panjang 100 secara eksplisit
            // kecuali jika ada batasan khusus. Password akan di-hash oleh Laravel.
            $table->string('password');

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
        Schema::dropIfExists('admins');
    }
};
