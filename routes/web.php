<?php

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

