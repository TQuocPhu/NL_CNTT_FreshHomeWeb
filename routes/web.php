<?php

use App\Http\Controllers\Clients\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('clients.pages.home');
});

Route::get('/about', function () {
    return view('clients.pages.about');
});

Route::get('/service', function () {
    return view('clients.pages.services');
});

Route::get('/team', function () {
    return view('clients.pages.team');
});

Route::get('/faq', function() {
    return view('clients.pages.faq');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register_post');