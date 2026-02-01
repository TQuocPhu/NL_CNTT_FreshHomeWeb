<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function() {
        return view('admin.pages.dashboard');
    });

    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

});