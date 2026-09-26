<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl(),
            'price' => fake()->randomFloat(2, 100, 2000),
            'duration' => fake()->randomElement(['2 hours', 'Half day', 'Full day']),
            'location' => 'Agafay, Morocco',
            'category' => fake()->randomElement(['adventure', 'food', 'relax']),
            'max_guests' => fake()->numberBetween(4, 12),
            'status' => true,
        ];
    }
}
