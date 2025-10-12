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
        'product_id',
        'bid_amount',
        'status',
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2',
    ];

    // Relationships
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWinning($query)
    {
        return $query->where('status', 'won');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helpers
    public function isWinning()
    {
        return $this->status === 'won';
    }

    public function isOutbid()
    {
        return $this->status === 'outbid';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}