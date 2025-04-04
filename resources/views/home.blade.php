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
                        <p class="card-text">BDT {{ $product->starting_price }}</p>
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
                <th>Total Price</th> <!-- New column -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sortedAuctions = $liveAuctions->sortByDesc(function($auction) {
                    return $auction->bids->max('updated_at');
                });
            @endphp

            @foreach ($sortedAuctions as $index => $auction)
                @php
                    $isRecentlyUpdated = $auction->bids->max('updated_at') && $auction->bids->max('updated_at')->diffInMinutes(now()) < 10; // Highlight if updated within the last 10 minutes
                @endphp
                <tr class="{{ $isRecentlyUpdated ? 'table-success' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $auction->product->name }}</td>
                    <td>BDT {{ $auction->product->starting_price }}</td> 
                    <td>
                        @if ($auction->bids->count() > 0)
                            BDT {{ $auction->bids->max('bid_amount') }}
                        @else
                            No bids yet
                        @endif
                    </td>
                    <td>{{ $auction->bids->count() }}</td>
                    <td>
                        @if ($auction->bids->count() > 0)
                            BDT {{ $auction->product->starting_price + $auction->bids->max('bid_amount') }}
                        @else
                            BDT {{ $auction->product->starting_price }}
                        @endif
                    </td>
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