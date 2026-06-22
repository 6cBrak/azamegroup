<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

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

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'unit_price'   => $item['price'],
                'quantity'     => $item['quantity'],
                'subtotal'     => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        $whatsappMessage = $this->buildWhatsAppMessage($order, $cart);
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
            $lines[] = "• {$item['name']} x{$item['quantity']} = " . number_format($item['price'] * $item['quantity'], 2) . " DA";
        }
        $lines[] = "";
        $lines[] = "TOTAL: " . number_format($order->total, 2) . " DA";

        return implode("\n", $lines);
    }
}
