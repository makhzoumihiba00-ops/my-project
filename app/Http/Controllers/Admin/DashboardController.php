<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $monthExpression = DB::connection()->getDriverName() === 'mysql'
            ? "DATE_FORMAT(visit_date, '%Y-%m')"
            : "strftime('%Y-%m', visit_date)";

        $monthly = Order::query()
            ->whereIn('status', ['confirmed', 'completed'])
            ->selectRaw("{$monthExpression} as month, SUM(total_price) as revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', [
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'confirmedBookings' => Order::where('status', 'confirmed')->count(),
            'completedTours' => Order::where('status', 'completed')->count(),
            'totalRevenue' => Order::whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
            'recentOrders' => Order::with('package')->latest()->limit(8)->get(),
            'revenueLabels' => $monthly->pluck('month')->values(),
            'revenueData' => $monthly->pluck('revenue')->map(fn ($value): float => (float) $value)->values(),
            'orderLabels' => Order::query()
                ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('month')
                ->values(),
            'orderCounts' => Order::query()
                ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total')
                ->values(),
            'packagePopularity' => Package::withCount('orders')->orderByDesc('orders_count')->limit(5)->get(),
        ]);
    }
}
