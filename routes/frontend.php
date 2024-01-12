<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'frontend','as'=>'frontend.'], function (){
    Route::get('home',[\App\Http\Controllers\Frontend\HomeController::class,'index'])->name('home');
    Route::get('product-details/{slug}',[\App\Http\Controllers\Frontend\ProductController::class,'details'])->name('product_details');
    Route::get('shop-cart',[\App\Http\Controllers\Frontend\CartController::class,'shop_cart'])->name('shop_cart');

    Route::group(['prefix' => 'auth','as'=>'auth.'], function (){
        Route::post('register', [\App\Http\Controllers\Frontend\Auth\RegisterController::class,'submit'])->name('registration.submit');
        Route::post('login', [\App\Http\Controllers\Frontend\Auth\LoginController::class,'submit'])->name('login.submit');
    });
});
