<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == RUTE PUBLIK (BISA DIAKSES SEMUA) ==
Route::get('/', [HomeController::class, 'landing'])->name('landing');

// == RUTE OTENTIKASI (HANYA UNTUK TAMU) ==
Route::middleware('guest:customer')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Halaman tunggu persetujuan
Route::get('/pending-approval', function () {
    return view('auth.pending');
})->name('auth.pending');


// == RUTE YANG MEMBUTUHKAN LOGIN CUSTOMER ==
Route::middleware('auth:customer')->group(function () {
    // Halaman Utama & Katalog
    Route::get('/home', [HalamanUtamaController::class, 'index'])->name('home');
    Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/produk/{product}', [ProductController::class, 'show'])->name('product.show');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Profil Pengguna
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profil/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Keranjang Belanja - Route yang Diperluas
    Route::prefix('keranjang')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/tambah/{product}', [CartController::class, 'add'])->name('add');
        Route::patch('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/hapus', [CartController::class, 'remove'])->name('remove');
        Route::delete('/kosongkan', [CartController::class, 'clear'])->name('clear');
        Route::get('/jumlah', [CartController::class, 'getCartCount'])->name('count');
        Route::get('/total', [CartController::class, 'getCartTotal'])->name('total');
    });

    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::put('/address/{address}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/address/{address}/select', [AddressController::class, 'selectForCheckout'])->name('address.select');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/order/confirmation/{transaction}', [OrderDetailController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/order/{transaction}', [OrderDetailController::class, 'show'])->name('order.show');

    
    Route::get('/checkout', [OrderDetailController::class, 'checkout'])->name('checkout.show');
    Route::post('/checkout', [OrderDetailController::class, 'store'])->name('checkout.store');
    Route::get('/order/confirmation/{transaction}', [OrderDetailController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/orders', [OrderDetailController::class, 'index'])->name('order.history');
    Route::get('/orders/{transaction}', [OrderDetailController::class, 'show'])->name('order.show');
});