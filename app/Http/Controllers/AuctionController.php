<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Product;

class AuctionController extends Controller
{
    /**
     * Display a listing of the auctions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $auctions = Auction::all();
        return view('auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new auction.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auctions.create');
    }

    /**
     * Store a newly created auction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after:start_time',
            'bid_increment' => 'required|numeric|min:1',
        ]);

        Auction::create($request->all());

        return redirect()->route('a')
                ->with('success', 'Auction created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
    {
        $auction->load('bids');
        return view('auctions.index', compact('auction'));
    }
}
