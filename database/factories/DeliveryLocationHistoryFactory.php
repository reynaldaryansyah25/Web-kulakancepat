<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\DeliveryLocationHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryLocationHistoryFactory extends Factory
{
    protected $model = DeliveryLocationHistory::class;

    public function definition(): array
    {
        return [
            'delivery_id' => Delivery::factory(),
            // Lokasi acak di sekitar Indonesia
            'latitude' => $this->faker->latitude(-8, 6),
            'longitude' => $this->faker->longitude(95, 141),
            'recorded_at' => now(),
        ];
    }
}
