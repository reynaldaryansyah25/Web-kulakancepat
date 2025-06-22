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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id_product');
            $table->string('name_product');
            $table->string('SKU')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('total_stock')->default(0);
            // $table->binary('image')->nullable(); // Opsi BLOB
            $table->string('image_path')->nullable(); // REKOMENDASI: Path/URL gambar
            $table->timestamp('created')->nullable()->useCurrent();
            $table->timestamp('updated')->nullable()->useCurrentOnUpdate();
            $table->unsignedInteger('id_product_category')->nullable();

            $table->foreign('id_product_category')
                ->references('id_product_category')
                ->on('products_category')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
