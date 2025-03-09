@extends('layouts.app')

@section('content')
@if (!Auth::check())
    <script type="text/javascript">
        window.location = "{{ route('login') }}"; // Redirect to login page
    </script>
@else
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Welcome to Deshi Bid</h1>

    <!-- Banner Section -->
    <div class="banner text-center my-4">
        <h2>Find the Best Deals on Auctions!!</h2>
        <a href="{{ route('auctions.index') }}" class="btn btn-primary">View Auctions</a>
    </div>

    <!-- Featured Auctions -->
    <h3>Featured Auctions</h3>
    <div class="row">
        @foreach($featuredProducts as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $product->images) }}" alt="{{ $product->name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">BDT {{ number_format($product->starting_price, 2) }}</p>
                        <a href="{{ route('bids.create', ['auction_id' => $product->id]) }}" class="btn btn-info">Bid Now</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Live Auctions -->
    <h3>Live Auctions</h3>
    <div class="row">
        @foreach ($liveAuctions as $auction)
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h4>{{ $auction->product->name }}</h4>
                    <p>Starting Price: BDT {{ number_format($auction->starting_price, 2) }}</p>
                    <p>Current Bid: 
                        @if ($auction->bids->count() > 0)
                            BDT {{ number_format($auction->bids->max('bid_amount'), 2) }}
                        @else
                            No bids yet
                        @endif
                    </p>
                    <p>Total Bids: {{ $auction->bids->count() }}</p>
                    <a href="{{ route('bids.create', ['auction_id' => $auction->id]) }}" class="btn btn-primary">Bid Now</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection