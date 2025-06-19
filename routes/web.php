<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PublicItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default dashboard view at "/"
Route::get('/', [PublicItemController::class, 'index'])->name('home');

// Public item routes (shop, cart, etc.)
Route::post('/add-to-cart/{id}', [PublicItemController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [PublicItemController::class, 'cart'])->name('cart');
Route::put('/cart/update/{id}', [PublicItemController::class, 'updateCart'])->name('cart.update');
Route::post('/remove-from-cart/{id}', [PublicItemController::class, 'removeFromCart'])->name('remove.from.cart');
Route::delete('/cart/{id}/remove', [PublicItemController::class, 'remove'])->name('cart.remove');
Route::post('/stripe/start', [StripeController::class, 'start'])->name('stripe.start');
Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/invoice/{order}', [StripeController::class, 'invoice'])->name('invoice.download');

// Checkout routes
Route::get('/checkout', [PublicItemController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order-success', function () {
    return view('checkout.success');
})->name('order.success');

// Admin Items routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

// Admin Brands routes
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

// Admin Models routes
Route::get('/models', [ModelController::class, 'index'])->name('modal.index');
Route::get('/models/create', [ModelController::class, 'create'])->name('modal.create');
Route::post('/models', [ModelController::class, 'store'])->name('modal.store');
Route::get('/models/{model}/edit', [ModelController::class, 'edit'])->name('modal.edit');
Route::put('/models/{model}', [ModelController::class, 'update'])->name('modal.update');
Route::delete('/models/{model}', [ModelController::class, 'destroy'])->name('modal.destroy');
Route::get('/stripe/start', [StripeController::class, 'start'])->name('stripe.start');
Route::Post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
// Brand's models AJAX route
Route::get('/brands/{brand}/models', function ($brandId) {
    return \App\Models\DeviceModel::where('brand_id', $brandId)->get();
})->name('brands.models');
