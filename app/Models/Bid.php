<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'user_id',
        'bid_amount',
        'product_id',
    ];

    /**
     * Get the auction that owns the bid.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    /**
     * Get the user that owns the bid.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

