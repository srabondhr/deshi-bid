<!-- resources/views/bids/bid.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place a Bid</title>
</head>
<body>
    <h1>Bid on {{ $product->name }}</h1>
    
    <p><strong>Current Price:</strong> ${{ $product->current_price }}</p>

    <form action="{{ route('bids.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <label for="bid_amount">Your Bid Amount:</label>
        <input type="number" name="bid_amount" min="{{ $product->current_price + 1 }}" required>

        <button type="submit">Place Bid</button>
    </form>

    <a href="{{ route('auctions.index') }}">Back to Auctions</a>
</body>
</html>
