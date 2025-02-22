<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/bids', [BidController::class, 'store'])->middleware('auth')->name('bids.store');
Route::resource('auctions', AuctionController::class)->middleware('auth');
Route::post('/buy-now/{product}', [BuyNowController::class, 'buyNow'])->middleware('auth')->name('buy_now');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::post('/admin/settings', [AdminController::class, 'updateSettings']);
Route::post('/admin/ban/{id}', [AdminController::class, 'banUser']);
