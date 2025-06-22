<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori sudah ada sebelum membuat produk jika produk memerlukan kategori
        // Jika tidak, jalankan ProductCategorySeeder terlebih dahulu di DatabaseSeeder.php

        Product::factory()->count(50)->create(); // Membuat 50 produk contoh
    }
}
