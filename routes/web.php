<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BidderController;
use App\Http\Controllers\SellerController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', fn() => redirect()->route('home'))->name('home.redirect');

// Authentication Routes with Email Verification
Auth::routes(['verify' => true]);

// Dashboard Route (Accessible only to verified users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

// Product & Review Routes (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Bidding & Auction Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('auctions', AuctionController::class);
    Route::post('/bids', [BidController::class, 'store'])->name('bids.store');
    Route::get('/bids/create/{auction_id}', [BidController::class, 'create'])->name('bids.create');
    Route::post('/buy-now/{product}', [BuyNowController::class, 'buyNow'])->name('buy_now');
    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
});

// Profile Routes (Authenticated Users Only)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::put('/settings', [AdminController::class, 'updateSettings']);
    Route::delete('/ban/{id}', [AdminController::class, 'banUser']);
});

// Bidder Routes
Route::middleware(['auth', 'role:bidder'])->prefix('bidder')->group(function () {
    Route::get('/dashboard', [BidderController::class, 'dashboard'])->name('bidder.dashboard');
});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
});
