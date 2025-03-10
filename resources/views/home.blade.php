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
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Starting Price</th>
                <th>Current Bid</th>
                <th>Total Bids</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($liveAuctions as $index => $auction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $auction->product->name }}</td>
                    <td>BDT {{ number_format($auction->starting_price, 2) }}</td>
                    <td>
                        @if ($auction->bids->count() > 0)
                            BDT {{ number_format($auction->bids->max('bid_amount'), 2) }}
                        @else
                            No bids yet
                        @endif
                    </td>
                    <td>{{ $auction->bids->count() }}</td>
                    <td>
                        <a href="{{ route('bids.create', ['auction_id' => $auction->id]) }}" class="btn btn-primary">Bid Now</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection