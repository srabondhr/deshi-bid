<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'starting_price',
        'start_time',
        'end_time',
        'current_price',
        'bid_increment',
        'status',
        'winning_bid_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'starting_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'bid_increment' => 'decimal:2',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'auction_id');
    }

    public function winningBid()
    {
        return $this->belongsTo(Bid::class, 'winning_bid_id');
    }

    public function winner()
    {
        return $this->winningBid ? $this->winningBid->user : null;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending')
            ->where('start_time', '>', now());
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended')
            ->orWhere(function($q) {
                $q->where('end_time', '<=', now());
            });
    }

    // Status Helpers
    public function isActive()
    {
        return $this->status === 'active' 
            && $this->start_time <= now() 
            && $this->end_time > now();
    }

    public function isPending()
    {
        return $this->status === 'pending' && $this->start_time > now();
    }

    public function hasEnded()
    {
        return $this->status === 'ended' || $this->end_time <= now();
    }

    public function getTimeRemaining()
    {
        if ($this->hasEnded()) {
            return 'Ended';
        }
        
        if ($this->isPending()) {
            return 'Starts ' . $this->start_time->diffForHumans();
        }

        return $this->end_time->diffForHumans(null, true) . ' remaining';
    }

    // Bid Helpers
    public function getHighestBid()
    {
        return $this->bids()->orderBy('bid_amount', 'desc')->first();
    }

    public function getMinimumBidAmount()
    {
        $highestBid = $this->getHighestBid();
        $currentPrice = $highestBid ? $highestBid->bid_amount : $this->starting_price;
        return $currentPrice + $this->bid_increment;
    }

    public function hasMetReservePrice()
    {
        if (!$this->product->reserve_price) {
            return true;
        }

        $highestBid = $this->getHighestBid();
        if (!$highestBid) {
            return false;
        }

        return $highestBid->bid_amount >= $this->product->reserve_price;
    }

    public function getTotalBids()
    {
        return $this->bids()->count();
    }

    // Auto-update status based on time
    public function updateStatus()
    {
        $now = now();

        if ($this->status === 'cancelled') {
            return;
        }

        if ($this->start_time > $now && $this->status !== 'pending') {
            $this->update(['status' => 'pending']);
        } elseif ($this->start_time <= $now && $this->end_time > $now && $this->status !== 'active') {
            $this->update(['status' => 'active']);
        } elseif ($this->end_time <= $now && $this->status !== 'ended') {
            $this->endAuction();
        }
    }

    public function endAuction()
    {
        $highestBid = $this->getHighestBid();
        
        if ($highestBid && $this->hasMetReservePrice()) {
            $this->update([
                'status' => 'ended',
                'winning_bid_id' => $highestBid->id,
            ]);
            
            // Update product status
            $this->product->update(['status' => 'sold']);
            
            // Mark winning bid
            $highestBid->update(['status' => 'won']);
            
            // Mark other bids as lost
            $this->bids()->where('id', '!=', $highestBid->id)->update(['status' => 'lost']);
        } else {
            // No winner (reserve not met or no bids)
            $this->update(['status' => 'ended']);
            $this->bids()->update(['status' => 'lost']);
        }
    }
}