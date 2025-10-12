<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add reserve_price if it doesn't exist
            if (!Schema::hasColumn('products', 'reserve_price')) {
                $table->decimal('reserve_price', 20, 2)->nullable()->after('starting_price');
            }
            
            // Add buy_now_price if it doesn't exist
            if (!Schema::hasColumn('products', 'buy_now_price')) {
                $table->decimal('buy_now_price', 20, 2)->nullable()->after('reserve_price');
            }
            
            // Modify images column to text if it's not
            if (Schema::hasColumn('products', 'images')) {
                $table->text('images')->nullable()->change();
            } else {
                $table->text('images')->nullable()->after('category');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['reserve_price', 'buy_now_price']);
        });
    }
};