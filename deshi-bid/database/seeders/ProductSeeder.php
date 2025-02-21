<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'user_id' => 2, // Assuming Seller User ID is 2
            'name' => 'Sample Product 1',
            'description' => 'This is a sample product description.',
            'category' => 'Electronics',
            'starting_price' => 100.00,
            'reserve_price' => 150.00,
            'images' => json_encode(['sample1.jpg']),
            'status' => 'active',
        ]);

        Product::create([
            'user_id' => 2, // Assuming Seller User ID is 2
            'name' => 'Sample Product 2',
            'description' => 'This is another sample product description.',
            'category' => 'Books',
            'starting_price' => 20.00,
            'reserve_price' => 30.00,
            'images' => json_encode(['sample2.jpg']),
            'status' => 'active',
        ]);
    }
}
