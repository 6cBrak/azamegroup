<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function export(Request $request): StreamedResponse
    {
        $query = Order::with('items');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('reference', 'like', "%{$s}%")->orWhere('customer_name', 'like', "%{$s}%")->orWhere('customer_phone', 'like', "%{$s}%"));
        }
        $orders = $query->latest()->get();

        $filename = 'commandes-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            // BOM UTF-8 pour Excel
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Référence', 'Date', 'Client', 'Téléphone', 'Email', 'Ville', 'Adresse', 'Articles', 'Total (F CFA)', 'Statut'], ';');
            foreach ($orders as $order) {
                $articles = $order->items->map(fn($i) => "{$i->product_name} x{$i->quantity}")->join(' | ');
                fputcsv($handle, [
                    $order->reference,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->customer_name,
                    $order->customer_phone,
                    $order->customer_email ?? '',
                    $order->customer_city,
                    $order->customer_address,
                    $articles,
                    number_format($order->total, 2, ',', ' '),
                    $order->status_label,
                ], ';');
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit(string $id) { abort(404); }
}
