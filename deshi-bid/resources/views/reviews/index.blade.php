@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reviews for {{ $product->name }}</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-primary mb-3">Add Review</a>

    @if ($reviews->isEmpty())
        <p>No reviews yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->rating }}</td>
                        <td>{{ $review->review }}</td>
                        <td>{{ $review->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to Products</a>
</div>
@endsection