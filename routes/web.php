<?php

use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerSettingsController;
use App\Http\Controllers\StoreOrderController;
use App\View\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', HomePage::data());
});
Route::post('commandes', [StoreOrderController::class, 'store'])->name('orders.store');

Route::prefix('vendeur')->name('seller.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('inscription', [SellerAuthController::class, 'create'])->name('register');
        Route::post('inscription', [SellerAuthController::class, 'store'])->name('register.store');
        Route::get('connexion', [SellerAuthController::class, 'login'])->name('login');
        Route::post('connexion', [SellerAuthController::class, 'authenticate'])->middleware('throttle:5,1')->name('login.store');
    });

    Route::middleware('auth')->group(function (): void {
        Route::get('tableau-de-bord', SellerDashboardController::class)->name('dashboard');
        Route::get('parametres', [SellerSettingsController::class, 'edit'])->name('settings');
        Route::put('parametres/profil', [SellerSettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('parametres/mot-de-passe', [SellerSettingsController::class, 'updatePassword'])->middleware('throttle:5,1')->name('settings.password');
        Route::post('produits', [SellerProductController::class, 'store'])->name('products.store');
        Route::delete('produits/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
        Route::patch('commandes/{order}/confirmer', [SellerOrderController::class, 'confirm'])->name('orders.confirm');
        Route::patch('commandes/{order}/pas-d-achat', [SellerOrderController::class, 'reject'])->name('orders.reject');
        Route::post('deconnexion', [SellerAuthController::class, 'logout'])->name('logout');
    });
});
