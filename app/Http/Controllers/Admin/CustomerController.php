<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('orders');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")
                ->orWhere('phone', 'like', "%{$s}%"));
        }

        $customers = $query->latest()->paginate(20)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $orders = $customer->orders()->with('items')->get();
        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Client supprimé.');
    }
}