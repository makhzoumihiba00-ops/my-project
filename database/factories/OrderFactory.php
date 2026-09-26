<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'package_id' => Package::factory(),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->phoneNumber(),
            'number_of_people' => fake()->numberBetween(1, 6),
            'visit_date' => fake()->dateTimeBetween('now', '+6 months'),
            'message' => fake()->optional()->sentence(),
            'total_price' => 500,
            'status' => 'pending',
        ];
    }
}
