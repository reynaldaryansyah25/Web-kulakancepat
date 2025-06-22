<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CustomerTierController;
use App\Http\Controllers\Admin\SystemSettingController;


// Route untuk login & logout admin (di luar middleware auth:admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Grup route untuk semua halaman dashboard yang memerlukan login admin
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    
    Route::resource('customers', CustomerController::class);
    Route::patch('customers/{customer}/approve', [CustomerController::class, 'approve'])->name('customers.approve');
    
    Route::resource('customer-tiers', CustomerTierController::class)->except(['show']);
    
    Route::resource('sales', SalesController::class);
    
    Route::get('orders', [TransactionController::class, 'index'])->name('orders.index');
    Route::get('orders/{transaction}', [TransactionController::class, 'show'])->name('orders.show');
    Route::patch('orders/{transaction}/update-status', [TransactionController::class, 'updateStatus'])->name('orders.updateStatus');
    
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    
    Route::get('settings', [SystemSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SystemSettingController::class, 'update'])->name('settings.update');

});
