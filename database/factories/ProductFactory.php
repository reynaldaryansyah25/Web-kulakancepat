<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory; // Import ProductCategory
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Ambil ID kategori yang ada secara acak, atau null jika tidak ada kategori
        $categoryIds = ProductCategory::pluck('id_product_category')->toArray();
        $randomCategoryId = !empty($categoryIds) ? $this->faker->randomElement($categoryIds) : null;

        $productName = $this->faker->catchPhrase(); 

        return [
            'name_product' => $productName,
            'SKU' => strtoupper($this->faker->unique()->bothify('???-#####')),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5000, 20500000),
            'total_stock' => $this->faker->numberBetween(0, 150),
            'image_path' => 'https://placehold.co/600x400/' . $this->faker->hexColor(false) . '/fff?text=' . urlencode($productName),
            'id_product_category' => $randomCategoryId,
            'created' => now(),
            'updated' => now(),
        ];
    }
}
