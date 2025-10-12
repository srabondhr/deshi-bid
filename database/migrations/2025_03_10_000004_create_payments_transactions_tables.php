<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Payments table
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('auction_id')->nullable()->constrained()->onDelete('set null');
                $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
                $table->string('transaction_id')->unique();
                $table->decimal('amount', 10, 2);
                $table->enum('payment_method', ['bkash', 'nagad', 'cash']);
                $table->enum('payment_type', ['auction_win', 'buy_now']);
                $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])
                    ->default('pending');
                $table->text('payment_details')->nullable(); // Store API response
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });
        }
        
        // Transactions table
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('payment_id')->constrained()->onDelete('cascade');
                $table->enum('type', ['payment', 'refund', 'commission']);
                $table->decimal('amount', 10, 2);
                $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
        
        // Admin Settings table (for site configuration)
        if (!Schema::hasTable('admin_settings')) {
            Schema::create('admin_settings', function (Blueprint $table) {
                $table->id();
                $table->string('setting_name')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string'); // string, number, boolean, json
                $table->timestamps();
            });
        }
        
        // Notifications table (for in-app notifications)
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('admin_settings');
        Schema::dropIfExists('notifications');
    }
};