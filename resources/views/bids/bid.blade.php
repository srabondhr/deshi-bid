@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Place a Bid</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('bids.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="auction_id" value="{{ $auction->id }}">
                        <input type="hidden" name="product_id" value="{{ $auction->product->id }}">

                        <div class="form-group">
                            <label for="current_highest_bid">Current Highest Bid:</label>
                            <input type="text" id="current_highest_bid" class="form-control" 
                                   value="BDT {{ $auction->bids->max('bid_amount') ?? $auction->starting_price }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="bid_amount">Your Bid Amount:</label>
                            <input type="text" id="bid_amount" class="form-control" 
                                   value="BDT {{ $auction->bids->max('bid_amount') ?? $auction->starting_price }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="new_bid_amount">New Bid Amount (with increment):</label>
                            <input type="number" id="new_bid_amount" name="bid_amount" class="form-control" 
                                   min="{{ ($auction->bids->max('bid_amount') ?? $auction->starting_price) + $auction->bid_increment }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Place Bid</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('auctions.index') }}" class="btn btn-secondary">Back to Auction</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const newBidInput = document.getElementById('new_bid_amount');
        const currentBid = parseFloat(document.getElementById('current_highest_bid').value.replace('BDT ', ''));
        const bidIncrement = {{ $auction->bid_increment }};

        newBidInput.min = (currentBid + bidIncrement).toFixed(2);
        newBidInput.value = newBidInput.min;
    });
</script>
@endsection
