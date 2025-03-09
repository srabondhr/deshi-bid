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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('home');
})->name('home.redirect');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('products', ProductController::class);
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::post('/bids', [BidController::class, 'store'])->middleware('auth')->name('bids.store');
Route::resource('auctions', AuctionController::class)->middleware('auth');

Route::get('/bids/create/{auction_id}', [BidController::class, 'create'])->name('bids.create');

Route::post('/buy-now/{product}', [BuyNowController::class, 'buyNow'])->middleware('auth')->name('buy_now');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::put('/admin/settings', [AdminController::class, 'updateSettings'])->middleware('auth');
Route::delete('/admin/ban/{id}', [AdminController::class, 'banUser'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
});

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
