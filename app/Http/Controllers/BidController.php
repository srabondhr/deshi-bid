<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Auction;

class BidController extends Controller
{
    /**
     * Show the form for creating a new bid.
     *
     * @param  int  $auction_id
     * @return \Illuminate\View\View
     */
    public function create($auction_id)
    {
        $auction = Auction::findOrFail($auction_id);
        return view('bids.bid', compact('auction'));
    }

    /**
     * Store a newly created bid in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'product_id' => 'required|exists:products,id',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        $auction = Auction::findOrFail($request->auction_id);
        $currentHighestBid = $auction->bids->max('bid_amount') ?? $auction->starting_price;
        $requiredBidAmount = $currentHighestBid + $auction->bid_increment;

        if ($request->bid_amount < $requiredBidAmount) {
            return back()->withErrors(['bid_amount' => 'Your bid must be at least BDT ' . number_format($requiredBidAmount, 2)]);
        }

        Bid::create([
            'auction_id' => $request->auction_id,
            'user_id' => auth()->id(),
            'bid_amount' => $request->bid_amount,
            'product_id' => $request->product_id,
        ]);

        return redirect()->back()->with('success', 'Bid placed successfully!');
    }
}