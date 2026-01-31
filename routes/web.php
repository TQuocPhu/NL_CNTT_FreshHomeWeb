<?php

use App\Http\Controllers\Clients\AccountController;
use App\Http\Controllers\Clients\AuthController;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\ForgotPasswordController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\LoginGoogleController;
use App\Http\Controllers\Clients\ProductController;
use App\Http\Controllers\Clients\ResetPasswordController;
use App\Http\Controllers\Clients\CheckoutController;
use App\Http\Controllers\Clients\ContactController;
use App\Http\Controllers\Clients\OrderController;
use App\Http\Controllers\Clients\ReviewController;
use App\Http\Controllers\Clients\SearchProductController;
use App\Http\Controllers\Clients\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('clients.pages.about');
})->name(name: 'about');

Route::get('/service', function () {
    return view('clients.pages.services');
})->name('service');

Route::get('/team', function () {
    return view('clients.pages.team');
})->name('team');

Route::get('/faq', function () {
    return view('clients.pages.faq');
})->name('faq');

//guest 

Route::middleware('guest')->group(function () {

    //Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register_post');

    //Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login_post');

    // đăng nhập google
    Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);

    //Quên mật khẩu
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetPasswordLinkToEmail'])->name('password.email');

    //Đặt lại mật khẩu người dùng
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

//Kích hoạt tài khoản
Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');


//Route khi đã đăng nhập
Route::middleware(['auth.custom'])->group(function () {
    //Đăng xuất
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Nhóm các routes liên quan tới chức năng của trang tài khoản
    Route::prefix('account')->group(function () {

        //Hiển thị trang tài khoản
        Route::get('/', [AccountController::class, 'index'])->name('account');

        //Cập nhật thông tin tài khoản
        Route::put('/update', [AccountController::class, 'updateProfileHandler'])->name('account.profile');

        //Đổi mật khẩu
        Route::post('/change-password', [AccountController::class, 'changePassword'])->name('account.change-password');

        //Thêm địa chỉ mới
        Route::post('/addresses', [AccountController::class, 'addAddress'])->name('account.addresses.add');

        //Chọn địa chỉ mặc định
        Route::put('/addresses/{id}', [AccountController::class, 'chooseDefaultAddress'])->name('account.addresses.update');

        //Xóa địa chỉ
        Route::delete('/addresses/{id}', [AccountController::class, 'removeAddress'])->name('account.addresses.delete');
    });
    //Trang thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/get-address', [CheckoutController::class, 'getAddresses'])->name('checkout.address.get');

    //Coupon
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
    Route::post('/checkout/cancel-coupon', [CheckoutController::class, 'cancelCoupon'])->name('checkout.cancelCoupon');

    //Đặt hàng
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::post('/checkout/paypal', [CheckoutController::class, 'placeOrderByPayPal'])->name('checkout.place-order-paypal');

    //Đơn hàng
    Route::get('/order/{id}', [OrderController::class, 'showOrderDetail'])->name('order.show-detail');
    Route::post('/order/{id}/cancel', [OrderController::class, 'canceledOrder'])->name('order.cancel');
    Route::post('/order/{id}/complete', [OrderController::class, 'completeOrder'])->name('order.completed');

    //Đánh giá
    Route::get('/review/{product}', [ReviewController::class, 'showReview'])->name('review.show');
    Route::post('/review', [ReviewController::class, 'createReview'])->name('review.create');

    //Yêu thích
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');

Route::get('/product/{slug}', [ProductController::class, 'detail'])->name('product.detail');

//Cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromMiniCart'])->name('cart.remove');

//mini cart
Route::get('/mini-cart', [CartController::class, 'loadMiniCart'])->name('cart.mini');

//Trang Giỏ hàng
Route::get('/cart', [CartController::class, 'showCartDetail'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
//remove trong trang giỏ hàng
Route::post('/cart/remove-cart', [CartController::class, 'removeCartItemFromDetailCart'])->name('cart.remove-cart');

//Liên hệ (Page Contact)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'sendContact'])->name('contact.send');

//Search
Route::get('/search', [SearchProductController::class, 'index'])->name('search.index');
Route::post('/search-img', [SearchProductController::class, 'searchByImage'])->name('search.searchImg');
