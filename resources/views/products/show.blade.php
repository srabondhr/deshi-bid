@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Product Details</h2>

    <div class="card">
        <div class="card-header">
            {{ $product->name }}
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Category:</strong> {{ $product->category }}</p>
            <p><strong>Starting Price:</strong> {{ $product->starting_price }}</p>
            <p><strong>Reserve Price:</strong> {{ $product->reserve_price }}</p>
            <p><strong>Status:</strong> {{ $product->status }}</p>
            <p><strong>Images:</strong></p>
            @if ($product->images)
                @foreach (json_decode($product->images) as $image)
                    <img src="{{ asset('images/' . $image) }}" alt="Product Image" class="img-thumbnail" width="150">
                @endforeach
            @endif
        </div>
    </div>

    <form action="{{ route('buy_now', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success mt-3">Buy Now for ${{ $product->reserve_price }}</button>
    </form>

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to Products</a>
</div>
@endsection