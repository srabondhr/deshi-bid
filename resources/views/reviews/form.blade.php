@if(auth()->check())
    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product_id }}">
        <div class="mb-2">
            <label for="rating">Rating (1-5):</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" required>
        </div>
        <div class="mb-2">
            <label for="review">Your Review:</label>
            <textarea name="review" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
@else
    <p><a href="{{ route('login') }}">Login</a> to leave a review.</p>
@endif
