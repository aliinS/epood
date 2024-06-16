<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingCartController;

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
    $products = App\Models\Product::all();
    return view('welcome', compact('products'));
})->name('welcome');

Route::get('/products/{product}', function (Product $product) {
    return view('product', compact('product'));
})->name('product.detail');

Route::get('/cart', [ShoppingCartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add/{product}', [ShoppingCartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{itemId}', [ShoppingCartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{itemId}', [ShoppingCartController::class, 'removeFromCart'])->name('cart.remove');


Route::get('/random-product', function () {
    $randomProductId = \App\Models\Product::inRandomOrder()->first()->id;
    return redirect()->route('product.detail', $randomProductId);
})->name('random.product');

Route::get('/checkout', [ShoppingCartController::class, 'checkout'])->name('checkout');

Route::post('/checkout', [CheckoutController::class, 'createCheckoutSession'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');