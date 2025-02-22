<form action="{{ route('auctions.store') }}" method="POST">
    @csrf
    <label>Start Time:</label>
    <input type="datetime-local" name="start_time" required>
    
    <label>End Time:</label>
    <input type="datetime-local" name="end_time" required>
    
    <label>Bid Increment:</label>
    <input type="number" name="bid_increment" required>

    <button type="submit">Create Auction</button>
</form>
