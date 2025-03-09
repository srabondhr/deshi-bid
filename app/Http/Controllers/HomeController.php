<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Auction; // Make sure to import your Auction model

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application home page with featured products.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $featuredProducts = Product::where('status', 'active')->take(6)->get();
        $liveAuctions = Auction::all(); // Fetch all auctions without filtering

        return view('home', compact('featuredProducts', 'liveAuctions'));
    }
}
