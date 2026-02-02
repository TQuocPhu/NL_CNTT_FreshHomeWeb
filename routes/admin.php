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
    });
});
