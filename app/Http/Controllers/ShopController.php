<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('active', true)->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_fr', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%")
                  ->orWhere('description_fr', 'like', "%{$search}%");
            });
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        match ($request->sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest'     => $query->latest(),
            default      => $query->orderBy('id'),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('active', true)->whereNull('parent_id')->orderBy('sort_order')->get();
        $currentCategory = $request->category;

        return view('shop.index', compact('products', 'categories', 'currentCategory'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('active', true)->with('category')->firstOrFail();

        $reviews = $product->approvedReviews()->get();
        $avgRating = $reviews->avg('rating');
        $reviewCount = $reviews->count();

        $related = Product::where('active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // Track recently viewed (store last 6 unique product IDs in session)
        $viewed = session('recently_viewed', []);
        $viewed = array_filter($viewed, fn($id) => $id !== $product->id);
        array_unshift($viewed, $product->id);
        $viewed = array_slice($viewed, 0, 6);
        session(['recently_viewed' => $viewed]);

        $recentlyViewed = Product::where('active', true)
            ->whereIn('id', array_diff($viewed, [$product->id]))
            ->get()
            ->sortBy(fn($p) => array_search($p->id, $viewed));

        return view('shop.show', compact('product', 'related', 'reviews', 'avgRating', 'reviewCount', 'recentlyViewed'));
    }
}
