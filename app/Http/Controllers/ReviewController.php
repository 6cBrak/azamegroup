<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId);

        $data = $request->validate([
            'author_name' => 'required|string|max:100',
            'author_email' => 'nullable|email|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $data['product_id'] = $product->id;
        $data['approved'] = false;

        Review::create($data);

        return back()->with('success', 'Merci pour votre avis ! Il sera publié après modération.');
    }
}
