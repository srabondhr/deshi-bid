@extends('layouts.app')

@section('title', 'Auctions')

@section('content')
<div class="container">
    <h1>Auctions</h1>
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
                </tr>
            </thead>
            <tbody>
                @foreach($auctions as $auction)
                    <tr>
                        <td>{{ $auction->id }}</td>
                        <td>{{ $auction->product->name }}</td>
                        <td>{{ $auction->start_time }}</td>
                        <td>{{ $auction->end_time }}</td>
                        <td>{{ $auction->bid_increment }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection