<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            // Add status column
            if (!Schema::hasColumn('auctions', 'status')) {
                $table->enum('status', ['pending', 'active', 'ended', 'cancelled'])
                    ->default('pending')
                    ->after('bid_increment');
            }
            
            // Add starting_price column
            if (!Schema::hasColumn('auctions', 'starting_price')) {
                $table->decimal('starting_price', 10, 2)->default(0)->after('product_id');
            }
            
            // Drop winning_bid_id foreign key constraint temporarily
            if (Schema::hasColumn('auctions', 'winning_bid_id')) {
                $table->dropForeign(['winning_bid_id']);
                $table->dropColumn('winning_bid_id');
            }
        });
        
        // Re-add winning_bid_id without foreign key (will add later after bids exist)
        Schema::table('auctions', function (Blueprint $table) {
            $table->unsignedBigInteger('winning_bid_id')->nullable()->after('bid_increment');
        });
    }

    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn(['status', 'starting_price']);
        });
    }
};