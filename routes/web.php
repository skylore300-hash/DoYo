<?php

use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerProductController;
use App\View\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', HomePage::data());
});

Route::prefix('vendeur')->name('seller.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('inscription', [SellerAuthController::class, 'create'])->name('register');
        Route::post('inscription', [SellerAuthController::class, 'store'])->name('register.store');
        Route::get('connexion', [SellerAuthController::class, 'login'])->name('login');
        Route::post('connexion', [SellerAuthController::class, 'authenticate'])->middleware('throttle:5,1')->name('login.store');
    });

    Route::middleware('auth')->group(function (): void {
        Route::get('tableau-de-bord', SellerDashboardController::class)->name('dashboard');
        Route::post('produits', [SellerProductController::class, 'store'])->name('products.store');
        Route::delete('produits/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
        Route::post('deconnexion', [SellerAuthController::class, 'logout'])->name('logout');
    });
});
