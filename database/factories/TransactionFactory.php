<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $customerIds = Customer::pluck('id_customer')->toArray();
        $randomCustomerId = !empty($customerIds) ? $this->faker->randomElement($customerIds) : null;

        return [
            'date_transaction' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'total_price' => $this->faker->randomFloat(2, 20000, 5000000), // Total harga acak
            'status' => $this->faker->randomElement(['WAITING_CONFIRMATION', 'PROCESS', 'SEND', 'FINISH', 'CANCEL']),
            'method_payment' => $this->faker->randomElement(['Transfer Bank', 'COD', 'E-Wallet']),
            'id_customer' => $randomCustomerId,
        ];
    }
}
