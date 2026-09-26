<?php

namespace Tests\Feature;

use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_a_booking_request_for_an_active_package(): void
    {
        $package = Package::factory()->create(['price' => 350, 'max_guests' => 6]);

        $response = $this->postJson(route('bookings.store'), [
            'package_id' => $package->id,
            'name' => 'Sara Anan',
            'email' => 'sara@example.com',
            'phone' => '+212600000000',
            'guests' => 2,
            'date' => now()->addWeek()->toDateString(),
            'notes' => 'A sunset request.',
            'company_website' => '',
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('orders', [
            'package_id' => $package->id,
            'customer_email' => 'sara@example.com',
            'total_price' => 700,
            'status' => 'pending',
        ]);
    }

    public function test_booking_cannot_exceed_package_capacity(): void
    {
        $package = Package::factory()->create(['max_guests' => 2]);

        $response = $this->postJson(route('bookings.store'), [
            'package_id' => $package->id,
            'name' => 'Sara Anan',
            'email' => 'sara@example.com',
            'phone' => '+212600000000',
            'guests' => 3,
            'date' => now()->addWeek()->toDateString(),
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('guests');
    }
}
