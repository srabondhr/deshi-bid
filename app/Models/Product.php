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
      
        'images',
        'status',
    ];

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bids for the product.
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}