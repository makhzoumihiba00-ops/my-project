<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $packages = Package::query()->where('status', true)->orderBy('id')->get();

        return view('landing.index', [
            'packages' => $packages->map(fn (Package $package): array => [
                'id' => (string) $package->id,
                'title' => $package->title,
                'category' => $package->category,
                'categoryLabel' => ucfirst($package->category),
                'tag' => 'Available on request',
                'price' => (float) $package->price,
                'duration' => $package->duration,
                'time' => 'By arrangement',
                'pace' => 'A memorable experience',
                'maxGuests' => $package->max_guests,
                'image' => $package->image ?: 'https://images.pexels.com/photos/36579390/pexels-photo-36579390.jpeg',
                'alt' => $package->title,
                'teaser' => $package->description,
                'description' => $package->description,
                'includes' => [],
                'itinerary' => [],
                'note' => 'Availability and final details are confirmed by the operator.',
            ])->all(),
            'bookingEndpoint' => route('bookings.store'),
            'site' => [
                'demoContent' => false,
                'loginUrl' => route('login'),
            ],
        ]);
    }

    public function storeBooking(StoreBookingRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $package = Package::query()->where('status', true)->findOrFail($validated['package_id']);

        if ($validated['guests'] > $package->max_guests) {
            return response()->json([
                'message' => 'This package cannot accommodate that many guests.',
                'errors' => ['guests' => ['Please choose a smaller group.']],
            ], 422);
        }

        $order = Order::create([
            'package_id' => $package->id,
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'number_of_people' => $validated['guests'],
            'visit_date' => $validated['date'],
            'message' => $validated['notes'] ?? null,
            'total_price' => $package->price * $validated['guests'],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'reference' => 'TH-'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT),
            'total' => $order->total_price,
        ]);
    }
}
