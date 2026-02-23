<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\CatalogPageController;
use App\Http\Controllers\CheckoutPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersPageController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('category.show', 1));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', CheckoutPageController::class)->name('checkout.show');
    Route::get('/orders', OrdersPageController::class)->name('orders.index');
    Route::post('/orders', OrderController::class)->name('orders.store');
});

require __DIR__.'/auth.php';

Route::get('/category/{id}', CatalogPageController::class)->name('category.show');
Route::get('/products/{id}', ProductPageController::class)->name('products.show');

Route::prefix('api')->middleware('web')->group(function () {
    Route::get('/cart', [CartController::class, 'show'])->name('api.cart.show');
    Route::post('/cart/items', [CartController::class, 'add'])->name('api.cart.add');
    Route::patch('/cart/items/{product}', [CartController::class, 'setQty'])->name('api.cart.setQty');
    Route::delete('/cart/items/{product}', [CartController::class, 'remove'])->name('api.cart.remove');
});
