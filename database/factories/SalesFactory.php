<?php

namespace Database\Factories;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */
class SalesFactory extends Factory
{
    protected $model = Sales::class;

    /**
     * The password that should be used for new users.
     *
     * @var string
     */
    protected static $password = 'password';

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_phone' => '08' . $this->faker->numerify('##########'), 
            'password' => static::$password, 
            'target_sales' => $this->faker->randomFloat(2, 10000000, 50000000),
            'created' => now(),
            'updated' => now(),
        ];
    }
}
