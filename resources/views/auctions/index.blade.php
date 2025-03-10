@extends('layouts.app')

@section('title', 'Auctions')

@section('content')
<div class="container">
    <h1>Auctions</h1>
    <div class="mb-3">
        <a href="{{ route('auctions.create') }}" class="btn btn-success">Create Auction</a>
    </div>
    @if($auctions->isEmpty())
        <p>No auctions available.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Bid Increment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auctions as $auction)
                    <tr>
                        <td>{{ $auction->id }}</td>
                        <td>{{ $auction->product->name }}</td>
                        <td>{{ $auction->start_time }}</td>
                        <td>{{ $auction->end_time }}</td>
                        <td>BDT {{ number_format($auction->bid_increment, 2) }}</td>
                        <td>
                            <p>Current Bid: 
                                @if ($auction->bids->isNotEmpty())
                                    BDT {{ number_format($auction->bids->max('bid_amount'), 2) }}
                                @else
                                    No bids yet
                                @endif
                            </p>
                            <p>Total Bids: {{ $auction->bids->count() }}</p>
                            <a href="{{ route('bids.create', $auction->id) }}" class="btn btn-primary">Bid Now</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection