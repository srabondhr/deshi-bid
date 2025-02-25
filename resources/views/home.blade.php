@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to Deshi Bid</h1>

    <!-- Banner Section -->
    <div class="banner text-center my-4">
        <h2>Find the Best Deals on Auctions!</h2>
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
                        <p class="card-text">${{ $product->starting_price }}</p>
                        <a href="{{ route('auctions.show', $product->id) }}" class="btn btn-info">Bid Now</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
