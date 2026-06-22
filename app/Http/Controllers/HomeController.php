<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('active', true)
            ->where('featured', true)
            ->with('category')
            ->take(8)
            ->get();

        $categories = Category::where('active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->withCount(['products' => fn($q) => $q->where('active', true)])
            ->get();

        $newProducts = Product::where('active', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'newProducts'));
    }
}
