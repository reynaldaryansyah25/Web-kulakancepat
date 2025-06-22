<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    protected $model = TransactionDetail::class;

    public function definition(): array
    {
        // ID produk dan transaksi biasanya akan di-override saat dipanggil dari TransactionSeeder
        // Namun, kita bisa sediakan fallback jika factory ini dipanggil langsung.
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $transaction = Transaction::inRandomOrder()->first() ?? Transaction::factory()->create();

        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $product->price ?? $this->faker->randomFloat(2, 10000, 500000);

        return [
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'id_product' => $product->id_product,
            'id_transaction' => $transaction->id_transaction,
        ];
    }
}
