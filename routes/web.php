<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/products', [ProductsController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product:slug}', [ProductsController::class, 'show'])
    ->name('products.show');

Route::resource('cart', CartController::class);


// Auth::routes(['verify' => true]);

Route::post('/paypal/webhook', function () {
    echo 'webhook called!';
});


require __DIR__.'/auth.php';

require __DIR__.'/dashboard.php';
