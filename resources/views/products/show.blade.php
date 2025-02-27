@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p><strong>Starting Price:</strong> BDT {{ $product->starting_price }}</p>
            <p><strong>Current Price:</strong> BDT {{ $product->auction->current_price ?? $product->starting_price }}</p>
            <img src="{{ asset('storage/' . $product->images) }}" alt="Product Image" class="img-fluid mb-3">

            <h3>Place a Bid</h3>
            <form action="{{ route('bids.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="bid_amount" class="form-control mb-2" placeholder="Enter your bid" required>
                <button type="submit" class="btn btn-success">Bid Now</button>
            </form>

            <h3 class="mt-4">Reviews</h3>
            @include('reviews.form', ['product_id' => $product->id])

            @foreach(optional($product->reviews) as $review)
                <div class="border p-2 mt-2">
                    <strong>{{ $review->user->name }}:</strong> 
                    <span>{{ $review->rating }}⭐</span>
                    <p>{{ $review->review }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to Products</a>
</div>
@endsection