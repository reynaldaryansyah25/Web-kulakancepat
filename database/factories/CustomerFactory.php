<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Sales;
use App\Models\CustomerTier; // <-- Tambahkan import ini
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;
    protected static $password = 'password';

    public function definition(): array
    {
        $salesIds = Sales::pluck('id_sales')->toArray();
        $randomSalesId = !empty($salesIds) ? $this->faker->randomElement($salesIds) : null;

        // Ambil tier pelanggan secara acak
        $tierIds = CustomerTier::pluck('id_customer_tier')->toArray();
        $randomTierId = !empty($tierIds) ? $this->faker->randomElement($tierIds) : null;

        // Tentukan plafon kredit acak berdasarkan tier
        $creditLimit = 0;
        if ($randomTierId) {
            $tier = CustomerTier::find($randomTierId);
            if ($tier->name == 'Bronze') $creditLimit = $this->faker->randomElement([0, 1000000, 2000000]);
            if ($tier->name == 'Silver') $creditLimit = $this->faker->randomElement([5000000, 7500000, 10000000]);
            if ($tier->name == 'Gold') $creditLimit = $this->faker->randomElement([20000000, 25000000, 30000000]);
            if ($tier->name == 'Platinum') $creditLimit = $this->faker->randomElement([50000000, 75000000, 100000000]);
        }

        return [
            'name_store' => 'Toko ' . $this->faker->companySuffix . ' ' . $this->faker->lastName,
            'name_owner' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_phone' => '08' . $this->faker->numerify('##########'),
            'password' => static::$password,
            'address' => $this->faker->address(),
            'status' => $this->faker->randomElement(['PENDING_APPROVE', 'ACTIVE', 'INACTIVE']),
            'id_sales' => $randomSalesId,
            'customer_tier_id' => $randomTierId, // <-- Tambahkan ini
            'credit_limit' => $creditLimit,       // <-- Tambahkan ini
            'created' => now(),
            'updated' => now(),
        ];
    }
}
