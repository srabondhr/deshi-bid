namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyNow;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BuyNowController extends Controller {
    public function buyNow(Request $request, Product $product) {
        BuyNow::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'price' => $product->reserve_price
        ]);

        $product->update(['status' => 'sold']);

        return redirect()->route('products.index')->with('success', 'Product purchased successfully!');
    }
}
