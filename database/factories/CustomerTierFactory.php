<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerTier>
 */
class CustomerTierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'min_monthly_purchase' => $this->faker->numberBetween(0, 10000000),
            'payment_term_days' => $this->faker->randomElement([7, 14, 30, 60]),
        ];
    }
}
