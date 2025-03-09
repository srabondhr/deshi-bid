<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model {
    use HasFactory;

    protected $fillable = ['product_id', 'start_time', 'end_time', 'bid_increment'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'auction_id');
    }
}
