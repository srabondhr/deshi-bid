<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'starting_price',
        'reserve_price',
        'buy_now_price',
        'images',
        'status',
    ];

    protected $casts = [
        'starting_price' => 'decimal:2',
        'reserve_price' => 'decimal:2',
        'buy_now_price' => 'decimal:2',
        'images' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auction()
    {
        return $this->hasOne(Auction::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function buyNowPurchases()
    {
        return $this->hasMany(BuyNow::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithBuyNow($query)
    {
        return $query->whereNotNull('buy_now_price');
    }

    // Helpers
    public function hasActiveAuction()
    {
        return $this->auction && $this->auction->status === 'active';
    }

    public function isSold()
    {
        return $this->status === 'sold';
    }

    public function getCurrentHighestBid()
    {
        return $this->bids()->orderBy('bid_amount', 'desc')->first();
    }

    public function getCurrentPrice()
    {
        $highestBid = $this->getCurrentHighestBid();
        return $highestBid ? $highestBid->bid_amount : $this->starting_price;
    }

    public function canBuyNow()
    {
        return $this->buy_now_price && $this->status === 'active' && !$this->isSold();
    }
}