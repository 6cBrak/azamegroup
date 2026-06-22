<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['approved' => true]);
        return back()->with('success', 'Avis approuvé.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Avis supprimé.');
    }
}
