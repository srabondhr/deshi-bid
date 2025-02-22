<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'bid_amount' => 'required|numeric|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($request->bid_amount <= $product->current_price) {
            return back()->withErrors(['bid_amount' => 'Your bid must be higher than the current price!']);
        }

        Bid::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'bid_amount' => $request->bid_amount
        ]);

        $product->update(['current_price' => $request->bid_amount]);

        return back()->with('success', 'Bid placed successfully!');
    }
}
