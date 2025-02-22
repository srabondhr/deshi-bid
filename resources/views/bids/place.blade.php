<form action="{{ route('bids.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="number" name="bid_amount" min="{{ $product->current_price + 1 }}" required>
    <button type="submit">Place Bid</button>
</form>
