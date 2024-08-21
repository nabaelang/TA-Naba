<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerController;
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


// AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'doLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/userregister', [AuthController::class, "userRegister"])->name('userregister');
Route::post('/userregister', [AuthController::class, "doUserRegister"])->name('do.userregister');

// ADMIN
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    // category
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/add', [CategoryController::class, 'create']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::get('/category/{id}/delete', [CategoryController::class, 'destroy']);
    // product
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/add', [ProductController::class, 'create']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::get('/product/{id}/delete', [ProductController::class, 'destroy']);
    // Transaction
    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::get('/transaction/{transaction}', [TransactionController::class, 'show'])->name("show.transaction");
    Route::get('/transaction/{id}', [TransactionController::class, 'show']);
    Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit']);
    Route::put('/transaction/{id}', [TransactionController::class, 'update'])->name("update-transaction");
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/get-data', [LaporanController::class, 'getData'])->name('laporan.getData');
    Route::get('/laporan/download-pdf', [LaporanController::class, 'downloadPdf'])->name('laporan.downloadPdf');
});

// PEMBELI
Route::get('/', [PageController::class, 'landingPage']);
Route::get('/product', [PageController::class, 'productPage']);
Route::get('/product/{id}', [PageController::class, 'productDetailPage']);
Route::get('/search', [ProductController::class, 'search'])->name('search');

// CUSTOMER
Route::middleware('auth:web')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/{product}', [CartController::class, 'addToCart'])->name('add_toCart');
    Route::patch('/cart/{cart}', [CartController::class, 'updateCart'])->name('update_cart');
    Route::delete('/cart/{cart}', [CartController::class, 'deleteCart'])->name('delete_cart');
    // Checkout
    Route::get('/checkout-page', [CheckoutController::class, 'checkoutPage'])->name('checkout.page');
    Route::post('/checkout-checkongkir', [CheckoutController::class, 'checkOngkir'])->name('checkOngkir');
    Route::post('/checkout', [CheckoutController::class, 'checkoutProcess'])->name('checkout.process');
    // Transaction
    Route::get('/transaction', [CustomerController::class, 'index']);
    Route::get('/transaction/{transaction}', [CustomerController::class, 'show'])->name('customer.show.transaction');
    // Profile
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [CustomerController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [CustomerController::class, 'update'])->name('profile.update');
    // Review
    Route::post('/review/{product}', [ReviewController::class, 'store'])->name('customer.review.store');
});
