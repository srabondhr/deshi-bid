@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Create Auction</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('auctions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="product_id">Product:</label>
                            <select id="product_id" name="product_id" class="form-control" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_time">Start Time:</label>
                            <input type="datetime-local" id="start_time" name="start_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="end_time">End Time:</label>
                            <input type="datetime-local" id="end_time" name="end_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="bid_increment">Bid Increment:</label>
                            <input type="number" id="bid_increment" name="bid_increment" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Create Auction</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
