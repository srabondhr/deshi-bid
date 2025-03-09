<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bids')) {
            Schema::create('bids', function (Blueprint $table) {
                $table->id();
                $table->foreignId('auction_id')->constrained()->onDelete('cascade'); // Foreign key to auctions table
                $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
                $table->decimal('bid_amount', 10, 2); // Ensure the bid_amount column is defined
                $table->timestamps();
            });
        } else {
            Schema::table('bids', function (Blueprint $table) {
                if (!Schema::hasColumn('bids', 'auction_id')) {
                    $table->foreignId('auction_id')->constrained()->onDelete('cascade'); // Foreign key to auctions table
                }
                if (!Schema::hasColumn('bids', 'bid_amount')) {
                    $table->decimal('bid_amount', 10, 2); // Ensure the bid_amount column is defined
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
