<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews for a specific product.
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()->with('user')->get();
        return view('reviews.index', compact('product', 'reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Product $product)
    {
        return view('reviews.create', compact('product'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('reviews.index', $product->id)
                         ->with('success', 'Review added successfully.');
    }
}