namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Product;

class AuctionController extends Controller {
    public function create() {
        return view('auctions.create');
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'bid_increment' => 'required|numeric|min:1'
        ]);

        Auction::create($request->all());

        return redirect()->route('products.index')->with('success', 'Auction created successfully!');
    }
}
