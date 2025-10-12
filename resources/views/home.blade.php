<!-- FILE: resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home - Deshi Bid')

@section('content')
<div class="container">
    <!-- Welcome Banner -->
    <div class="jumbotron bg-primary text-white text-center p-5 rounded mb-4">
        <h1 class="display-4">
            <i class="fas fa-gavel"></i> Welcome to Deshi Bid
        </h1>
        <p class="lead">Discover amazing deals through live auctions!</p>
        <hr class="my-4 bg-white">
        <p>Join thousands of users buying and selling unique items every day.</p>
        <a class="btn btn-light btn-lg" href="{{ route('auctions.index') }}" role="button">
            <i class="fas fa-search"></i> Browse Auctions
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-gavel fa-3x text-primary mb-3"></i>
                    <h3>{{ $liveAuctions->count() }}</h3>
                    <p class="text-muted">Live Auctions</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-box fa-3x text-success mb-3"></i>
                    <h3>{{ $featuredProducts->count() }}</h3>
                    <p class="text-muted">Featured Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h3>1000+</h3>
                    <p class="text-muted">Active Users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <h2 class="mb-4">
        <i class="fas fa-star text-warning"></i> Featured Products
    </h2>
    <div class="row mb-5">
        @forelse($featuredProducts as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" 
                             class="card-img-top product-image" 
                             alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" 
                             class="card-img-top product-image" 
                             alt="No image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="price-tag">BDT {{ number_format($product->starting_price, 2) }}</span>
                            @if($product->auction)
                                <span class="badge bg-success">
                                    <i class="fas fa-clock"></i> {{ $product->auction->getTimeRemaining() }}
                                </span>
                            @endif
                        </div>

                        @if($product->auction)
                            <a href="{{ route('auctions.show', $product->auction->id) }}" 
                               class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-gavel"></i> View Auction
                            </a>
                        @else
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-secondary btn-sm w-100">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No featured products available at the moment.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Live Auctions -->
    <h2 class="mb-4">
        <i class="fas fa-fire text-danger"></i> Live Auctions
    </h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Starting Price</th>
                    <th>Current Bid</th>
                    <th>Total Bids</th>
                    <th>Time Remaining</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($liveAuctions as $index => $auction)
                    @php
                        $isRecentlyUpdated = $auction->bids->max('updated_at') && 
                                            $auction->bids->max('updated_at')->diffInMinutes(now()) < 10;
                    @endphp
                    <tr class="{{ $isRecentlyUpdated ? 'table-success' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $auction->product->name }}</strong><br>
                            <small class="text-muted">{{ $auction->product->category }}</small>
                        </td>
                        <td>BDT {{ number_format($auction->starting_price, 2) }}</td>
                        <td>
                            @if($auction->bids->count() > 0)
                                <strong class="text-success">
                                    BDT {{ number_format($auction->bids->max('bid_amount'), 2) }}
                                </strong>
                            @else
                                <span class="text-muted">No bids yet</span>
                            @endif
                        </td>
                        <td>
                            <span class="bid-badge">{{ $auction->bids->count() }}</span>
                        </td>
                        <td>
                            <span class="auction-timer">
                                <i class="fas fa-clock"></i> {{ $auction->getTimeRemaining() }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('bids.create', $auction->id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-gavel"></i> Bid Now
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            <i class="fas fa-inbox"></i> No live auctions at the moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-md-6 mb-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                    <h4>Seller?</h4>
                    <p>List your products and start your auction today!</p>
                    @if(Auth::user()->isSeller())
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    @else
                        <p class="text-muted">
                            <small>You need a seller account to list products</small>
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <i class="fas fa-search fa-3x text-success mb-3"></i>
                    <h4>Looking for Deals?</h4>
                    <p>Browse our extensive collection of auctions!</p>
                    <a href="{{ route('auctions.index') }}" class="btn btn-success">
                        <i class="fas fa-search"></i> Browse All Auctions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh page every 30 seconds to update auction times
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endpush
@endsection