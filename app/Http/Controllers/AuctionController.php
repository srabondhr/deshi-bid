<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Product;

class AuctionController extends Controller {
    /**
     * Display a listing of the auctions.
     */
    public function index() {
        $auctions = Auction::all();
        return view('auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new auction.
     */
    public function create() {
        return view('auctions.create');
    }

    /**
     * Store a newly created auction in storage.php artisan route:list

     */
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'bid_increment' => 'required|numeric|min:1'
        ]);

        Auction::create($request->all());

        return redirect()->route('auctions.index')->with('success', 'Auction created successfully!');
    }

    /**
     * Display the specified auction.
     */
    public function show($id) {
        $auction = Auction::with('bids')->findOrFail($id);
        return view('auctions.show', compact('auction'));
    }
}
