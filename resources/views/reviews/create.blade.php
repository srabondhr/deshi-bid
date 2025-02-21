@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Review for {{ $product->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="rating">Rating</label>
            <select class="form-control" id="rating" name="rating" required>
                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1</option>
                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2</option>
                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3</option>
                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4</option>
                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5</option>
            </select>
        </div>

        <div class="form-group">
            <label for="review">Review</label>
            <textarea class="form-control" id="review" name="review" required>{{ old('review') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</div>
@endsection