<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model {
    use HasFactory;

    protected $fillable = ['product_id', 'start_time', 'end_time', 'current_price', 'bid_increment', 'winning_bid_id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
