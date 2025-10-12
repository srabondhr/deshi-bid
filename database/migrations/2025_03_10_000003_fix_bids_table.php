<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            // Add product_id if it doesn't exist
            if (!Schema::hasColumn('bids', 'product_id')) {
                $table->foreignId('product_id')
                    ->after('auction_id')
                    ->constrained()
                    ->onDelete('cascade');
            }
            
            // Add status column
            if (!Schema::hasColumn('bids', 'status')) {
                $table->enum('status', ['active', 'outbid', 'won', 'lost'])
                    ->default('active')
                    ->after('bid_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'status']);
        });
    }
};