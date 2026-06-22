<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, int $id)
    {
        $product = Product::where('active', true)->findOrFail($id);

        if (!$product->isInStock()) {
            return back()->with('error', __('app.out_of_stock'));
        }

        $cart = session('cart', []);
        $qty = max(1, (int) $request->quantity);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->getName(),
                'price'    => $product->price,
                'image'    => $product->getFirstImage(),
                'slug'     => $product->slug,
                'quantity' => $qty,
            ];
        }

        session(['cart' => $cart]);
        return back()->with('success', __('app.add_to_cart') . ' ✓');
    }

    public function update(Request $request, int $id)
    {
        $cart = session('cart', []);
        $qty = (int) $request->quantity;

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $qty;
        }

        session(['cart' => $cart]);
        return back();
    }

    public function remove(int $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back();
    }

    public function clear()
    {
        session()->forget('cart');
        return back();
    }
}
