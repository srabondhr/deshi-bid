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
                    <th>Total Price</th> <!-- New column -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sortedAuctions = $auctions->sortByDesc(function($auction) {
                        return $auction->bids->max('updated_at');
                    });
                @endphp
                @foreach($sortedAuctions as $auction)
                    @php
                        $isRecentlyUpdated = $auction->bids->max('updated_at') && $auction->bids->max('updated_at')->diffInMinutes(now()) < 10;
                    @endphp
                    <tr class="{{ $isRecentlyUpdated ? 'table-success' : '' }}">
                        <td>{{ $auction->id }}</td>
                        <td>{{ $auction->product->name }}</td>
                        <td>{{ $auction->start_time }}</td>
                        <td>{{ $auction->end_time }}</td>
                        <td>BDT {{ $auction->bid_increment }}</td>
                        <td>
                            @if ($auction->bids->isNotEmpty())
                                BDT {{ $auction->product->starting_price + $auction->bids->max('bid_amount') }}
                            @else
                                BDT {{ $auction->product->starting_price }}
                            @endif
                        </td>
                        <td>
                            <p>Current Bid: 
                                @if ($auction->bids->isNotEmpty())
                                    BDT {{ $auction->bids->max('bid_amount') }}
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