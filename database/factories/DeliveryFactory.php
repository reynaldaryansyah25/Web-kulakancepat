<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Sales;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    protected $model = Delivery::class;

    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::inRandomOrder()->first()->id_transaction,
            'sales_id' => Sales::inRandomOrder()->first()->id_sales, // Sales sebagai kurir
            'status' => $this->faker->randomElement(['Preparing', 'On The Way', 'Delivered']),
            'estimated_arrival' => $this->faker->dateTimeBetween('now', '+3 days'),
        ];
    }
}
