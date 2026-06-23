<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        // Sync displayed prices with DB so what the user sees matches what will be charged
        $productIds = array_column(array_values($cart), 'id');
        $dbPrices = Product::whereIn('id', $productIds)->pluck('price', 'id');
        $cart = collect($cart)->map(function ($item) use ($dbPrices) {
            if (isset($dbPrices[$item['id']])) {
                $item['price'] = $dbPrices[$item['id']];
            }
            return $item;
        })->all();

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $customer = auth('customer')->user();
        return view('checkout.index', compact('cart', 'total', 'customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:100',
            'city'    => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'notes'   => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        // Re-read prices from DB — never trust session-stored prices
        $productIds = array_column(array_values($cart), 'id');
        $dbPrices = Product::whereIn('id', $productIds)->pluck('price', 'id');

        $resolvedItems = [];
        $total = 0;
        foreach ($cart as $item) {
            $dbPrice = $dbPrices[$item['id']] ?? null;
            if ($dbPrice === null) {
                continue; // product removed or inactive
            }
            $subtotal = $dbPrice * $item['quantity'];
            $total += $subtotal;
            $resolvedItems[] = [
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'unit_price'   => $dbPrice,
                'quantity'     => $item['quantity'],
                'subtotal'     => $subtotal,
            ];
        }

        if (empty($resolvedItems)) {
            return redirect()->route('cart.index');
        }

        $order = Order::create([
            'reference'       => Order::generateReference(),
            'customer_id'     => auth('customer')->id(),
            'customer_name'   => $request->name,
            'customer_phone'  => $request->phone,
            'customer_email'  => $request->email,
            'customer_city'   => $request->city,
            'customer_address'=> $request->address,
            'notes'           => $request->notes,
            'total'           => $total,
            'status'          => 'pending',
        ]);

        foreach ($resolvedItems as $item) {
            OrderItem::create(array_merge(['order_id' => $order->id], $item));
        }

        session()->forget('cart');

        $whatsappMessage = $this->buildWhatsAppMessage($order, $resolvedItems);
        $whatsappNumber = Setting::get('whatsapp_number', config('app.whatsapp_number'));
        $whatsappUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappNumber)
            . '?text=' . urlencode($whatsappMessage);

        return view('checkout.success', compact('order', 'whatsappUrl'));
    }

    private function buildWhatsAppMessage(Order $order, array $cart): string
    {
        $lines = [];
        $lines[] = "🛒 Nouvelle commande - " . config('app.name');
        $lines[] = "Réf: {$order->reference}";
        $lines[] = "Client: {$order->customer_name}";
        $lines[] = "Tél: {$order->customer_phone}";
        $lines[] = "Ville: {$order->customer_city}";
        $lines[] = "Adresse: {$order->customer_address}";
        $lines[] = "";
        $lines[] = "--- Articles ---";
        foreach ($cart as $item) {
            $name = $item['product_name'] ?? $item['name'];
            $lines[] = "• {$name} x{$item['quantity']} = " . number_format($item['subtotal'], 2) . " F CFA";
        }
        $lines[] = "";
        $lines[] = "TOTAL: " . number_format($order->total, 2) . " F CFA";

        return implode("\n", $lines);
    }
}
