<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
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
            Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
            Route::post('/user/upgrade', [AdminUserController::class, 'upgradedStaff'])->name('admin.user.upgrade');
            Route::post('/user/update-status', [AdminUserController::class, 'updateStatus'])->name('admin.user.updateStatus');
        });

        Route::middleware(['permission:manage_categories'])->group(function () {
            // *********************
            //  Quản lý danh mục
            // *********************
            Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
            Route::get('/category/add', [AdminCategoryController::class, 'showFormAddCategory'])->name('admin.categories.add');
            Route::post('/category/add', [AdminCategoryController::class, 'addCategory'])->name('admin.categories.add-post');
            Route::post('/category/update', [AdminCategoryController::class, 'updateCategory'])->name('admin.categories.update');
            Route::post('/category/delete', [AdminCategoryController::class, 'deleteCategory'])->name('admin.categories.delete');
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
