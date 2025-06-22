<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh kategori
        $categories = [
            ['name' => 'Pakaian Pria', 'description' => 'Berbagai jenis pakaian untuk pria.'],
            ['name' => 'Pakaian Wanita', 'description' => 'Berbagai jenis pakaian untuk wanita.'],
            ['name' => 'Elektronik', 'description' => 'Peralatan elektronik rumah tangga dan gadget.'],
            ['name' => 'Makanan & Minuman', 'description' => 'Produk makanan dan minuman kemasan.'],
            ['name' => 'Kebutuhan Rumah Tangga', 'description' => 'Perlengkapan untuk kebutuhan sehari-hari di rumah.'],
        ];

        foreach ($categories as $category) {
            ProductCategory::firstOrCreate(['name' => $category['name']], $category);
        }

        // Atau jika ingin membuat banyak kategori acak:
        // ProductCategory::factory()->count(5)->create();
    }
}
