<?php

use App\Http\Controllers\Clients\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('clients.pages.home');
})->name('home');

Route::get('/about', function () {
    return view('clients.pages.about');
})->name(name: 'about');

Route::get('/service', function () {
    return view('clients.pages.services');
})->name('service');

Route::get('/team', function () {
    return view('clients.pages.team');
})->name('team');

Route::get('/faq', function() {
    return view('clients.pages.faq');
})->name('faq');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register_post');

Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login_post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');