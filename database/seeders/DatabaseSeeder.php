<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Package::query()->upsert([
            [
                'title' => 'Sunset camel ride & mint tea',
                'slug' => 'sunset-camel-ride-mint-tea',
                'description' => 'A gentle camel ride across the Agafay landscape followed by traditional mint tea at camp.',
                'image' => 'https://images.pexels.com/photos/36579390/pexels-photo-36579390.jpeg',
                'price' => 350,
                'duration' => '2 hours',
                'location' => 'Agafay, Morocco',
                'category' => 'adventure',
                'max_guests' => 12,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Quad trails & desert horizons',
                'slug' => 'quad-trails-desert-horizons',
                'description' => 'Follow a guide across open desert tracks, with a safety briefing, scenic stops, and mint tea.',
                'image' => 'https://images.pexels.com/photos/36579388/pexels-photo-36579388.jpeg',
                'price' => 550,
                'duration' => '3 hours',
                'location' => 'Agafay, Morocco',
                'category' => 'adventure',
                'max_guests' => 8,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dinner beneath the desert sky',
                'slug' => 'dinner-beneath-desert-sky',
                'description' => 'Enjoy a Moroccan dinner, welcome tea, and live music at a beautiful desert camp.',
                'image' => 'https://images.pexels.com/photos/25447708/pexels-photo-25447708.jpeg',
                'price' => 650,
                'duration' => '4 hours',
                'location' => 'Agafay, Morocco',
                'category' => 'food',
                'max_guests' => 12,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The complete Agafay evening',
                'slug' => 'complete-agafay-evening',
                'description' => 'Combine a quad ride, camel experience, sunset, mint tea, and dinner in one signature escape.',
                'image' => 'https://images.pexels.com/photos/24193958/pexels-photo-24193958.jpeg',
                'price' => 990,
                'duration' => '5 hours',
                'location' => 'Agafay, Morocco',
                'category' => 'adventure',
                'max_guests' => 8,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['slug'], ['title', 'description', 'image', 'price', 'duration', 'location', 'category', 'max_guests', 'status', 'updated_at']);
    }
}
