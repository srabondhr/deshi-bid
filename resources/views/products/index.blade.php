@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="container">
    <h2>Available Products</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Create Product</a>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="{{ asset('storage/' . $product->images) }}" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p><strong>Starting Price:</strong> ${{ $product->starting_price }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Auction</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection