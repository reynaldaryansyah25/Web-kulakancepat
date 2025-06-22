<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\SystemRecommendationLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SystemRecommendationLog>
 */
class SystemRecommendationLogFactory extends Factory
{
    protected $model = SystemRecommendationLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['low_stock_alert', 'new_product_promo', 'cross_sell']);
        $message = "This is a dummy message for type: {$type}.";

        return [
            'customer_id' => Customer::inRandomOrder()->first()->id_customer,
            'type' => $type,
            'message' => $message,
            'sent_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'metadata' => json_encode(['product_id' => rand(1, 50), 'source' => 'system_batch']),
        ];
    }
}
