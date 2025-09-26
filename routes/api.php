<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    return response()->json(['message' => 'Authenticated']);
});

//=== api/v1 ===//
Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('webecom/products', ProductController::class);
    // Route::apiResource('webecom/carts', CartController::class);
    Route::get('webecom/carts', [CartController::class, 'index']);   // GET
    Route::post('webecom/carts/add', [CartController::class, 'add']); // POST
    Route::post('webecom/carts/increment/{id}', [CartController::class, 'increment']); // POST
    Route::post('webecom/carts/decrement/{id}', [CartController::class, 'decrement']); // POST
    Route::delete('webecom/carts/remove/{id}', [CartController::class, 'remove']); // DELETE
    Route::post('webecom/carts/clear', [CartController::class, 'clear']); // POST
    Route::post('webecom/checkout', [CheckoutController::class, 'checkout']); // POST
    Route::post('webecom/orders', [OrderController::class, 'store']); // POST
});


