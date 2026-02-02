<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {



    Route::middleware(['check.auth.admin'])->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'loginAdmin'])->name('admin.login-post');
    });

    Route::middleware(['auth.custom'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        Route::middleware(['permission:manage_users'])->group(function () {
            // *********************
            //  Quản lý người dùng
            // *********************

        });

        Route::middleware(['permission:manage_categories'])->group(function () {
            // *********************
            //  Quản lý danh mục
            // *********************
            
        });

        Route::middleware(['permission:manage_products'])->group(function () {
            // *********************
            //  Quản lý sản phẩm
            // *********************
            
        });

        Route::middleware(['permission:manage_coupons'])->group(function () {
            // *********************
            //  Quản lý khuyến mãi
            // *********************
            
        });

        Route::middleware(['permission:manage_orders'])->group(function () {
            // *********************
            //  Quản lý đơn hàng
            // *********************
            
        });

        Route::middleware(['permission:manage_contacts'])->group(function () {
            // *********************
            //  Quản lý liên hệ
            // *********************
            
        });
    });
});
