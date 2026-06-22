<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('reference', 'like', "%{$s}%")->orWhere('customer_name', 'like', "%{$s}%")->orWhere('customer_phone', 'like', "%{$s}%"));
        }
        $orders = $query->latest()->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée.');
    }

    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit(string $id) { abort(404); }
}
