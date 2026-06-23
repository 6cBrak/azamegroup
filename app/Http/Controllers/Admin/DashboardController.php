<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'   => Product::count(),
            'categories' => Category::count(),
            'orders'     => Order::count(),
            'customers'  => Customer::count(),
            'revenue'    => Order::where('status', '!=', 'cancelled')->sum('total'),
            'pending'    => Order::where('status', 'pending')->count(),
            'low_stock'  => Product::where('stock', '<=', 5)->where('active', true)->count(),
        ];

        $recentOrders = Order::with('items')->latest()->take(10)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->where('active', true)->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
