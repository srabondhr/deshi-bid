<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::create([
            'user_id' => 3, // Assuming Buyer User ID is 3
            'product_id' => 1, // Assuming Product ID is 1
            'rating' => 5,
            'review' => 'Excellent product!',
        ]);

        Review::create([
            'user_id' => 3, // Assuming Buyer User ID is 3
            'product_id' => 2, // Assuming Product ID is 2
            'rating' => 4,
            'review' => 'Very good product, but could be improved.',
        ]);
    }
}
