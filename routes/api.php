<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RajaOngkirController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// RajaOngkir
Route::get('/rajaongkir/provinces', [RajaOngkirController::class, 'getProvinces'])->name('customer.rajaongkir.getProvinces');
Route::get('/rajaongkir/cities', [RajaOngkirController::class, 'getCities'])->name('customer.rajaongkir.getCities');
Route::post('/rajaongkir/checkOngkir', [RajaOngkirController::class, 'checkOngkir'])->name('customer.rajaongkir.checkOngkir');

// midtrans-callback
Route::post('/midtrans-callback', [CheckoutController::class, 'callback']);
