<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::middleware(['check.auth.admin'])->group(function () {

        // Hiển thị trang đăng nhập tài khoản quản trị
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

        // Đăng nhập tài khoản quản trị
        Route::post('/login', [AdminAuthController::class, 'loginAdmin'])->name('admin.login-post');
    });

    Route::middleware(['auth.custom', 'admin.data'])->group(function () {

        // Dashboard tổng quan
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Đăng xuất tài khoản
        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        // *********************
        //  Quản lý tài khoản
        // *********************

        // Hiển thị tài khoản admin
        Route::get('/profile', [AdminAccountController::class, 'index'])->name('admin.profile');
        
        // Cập nhật thông tin tài khoản
        Route::post('/profile/update', [AdminAccountController::class, 'updateProfile'])->name('admin.profile.update');
        
        // *********************
        //  Quản lý thông báo
        // *********************

        // Hiển thị danh sách thông báo
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notification.index');
        
        // Đọc thông báo mới
        Route::post('/notification/read', [AdminNotificationController::class, 'read'])->name('admin.notification.read');

        Route::middleware(['permission:manage_users'])->group(function () {
            // *********************
            //  Quản lý người dùng
            // *********************

            // Hiển thị danh sách tài khoản người dùng
            Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
            
            // Nâng cấp quyền hạn người dùng từ customer -> staff
            Route::post('/user/upgrade', [AdminUserController::class, 'upgradedStaff'])->name('admin.user.upgrade');
            
            // Cập nhật trạng thái tài khoản người dùng
            Route::post('/user/update-status', [AdminUserController::class, 'updateStatus'])->name('admin.user.updateStatus');
        });

        Route::middleware(['permission:manage_categories'])->group(function () {
            // *********************
            //  Quản lý danh mục
            // *********************

            // Hiển thị danh sách danh mục sản phẩm
            Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
            
            // Hiển thị trang thêm danh mục sản phẩm
            Route::get('/category/add', [AdminCategoryController::class, 'showFormAddCategory'])->name('admin.categories.add');
            
            // Thêm danh mục sản phẩm
            Route::post('/category/add', [AdminCategoryController::class, 'addCategory'])->name('admin.categories.add-post');
            
            // Cập nhật danh mục sản phẩm
            Route::post('/category/update', [AdminCategoryController::class, 'updateCategory'])->name('admin.categories.update');
            
            // Xóa danh mục sản phẩm khỏi cơ sở dữ liệu
            Route::post('/category/delete', [AdminCategoryController::class, 'deleteCategory'])->name('admin.categories.delete');
        });

        Route::middleware(['permission:manage_products'])->group(function () {
            // *********************
            //  Quản lý sản phẩm
            // *********************

            // Hiển thị danh sách sản phẩm
            Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
            
            // Hiển thị trang thêm sản phẩm
            Route::get('/product/add', [AdminProductController::class, 'showFormAddProduct'])->name('admin.products.add');
            
            // Thêm sản phẩm mới
            Route::post('/product/add', [AdminProductController::class, 'addProduct'])->name('admin.product.add-post');
            
            // Cập nhật sản phẩm
            Route::post('/product/update', [AdminProductController::class, 'updateProduct'])->name('admin.product.update');
            
            // Xóa sản phẩm
            Route::post('/product/delete', [AdminProductController::class, 'deleteProduct'])->name('admin.product.delete');
        });

        Route::middleware(['permission:manage_coupons'])->group(function () {
            // *********************
            //  Quản lý khuyến mãi
            // *********************

            // Hiển thị danh sách mã khuyến mãi
            Route::get('/coupons', [AdminCouponController::class, 'index'])->name('admin.coupons.index');
            
            // Hiển thị trang thêm mã khuyến mãi
            Route::get('/coupon/add', [AdminCouponController::class, 'showFormAddCoupon'])->name('admin.coupons.add');
            
            // Thêm mã khuyến mãi mới
            Route::post('/coupon/add', [AdminCouponController::class, 'addCoupon'])->name('admin.coupon.add-post');
            
            // Cập nhật mã khuyến mãi
            Route::post('/coupon/update', [AdminCouponController::class, 'updateCoupon'])->name('admin.coupon.update');
            
            // Xóa mã khuyến mãi
            Route::post('/coupon/delete', [AdminCouponController::class, 'deleteCoupon'])->name('admin.coupon.delete');
        });

        Route::middleware(['permission:manage_orders'])->group(function () {
            // *********************
            //  Quản lý đơn hàng
            // *********************

            // Hiển thị danh sách đơn hàng
            Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
            
            // Hiển thị chi tiết đơn hàng
            Route::get('/order/{id}', [AdminOrderController::class, 'showOrderDetailPage'])->name('admin.order-detail');
            
            // Xác nhận đơn hàng
            Route::post('/order/confirm', [AdminOrderController::class, 'confirmOrder'])->name('admin.order.confirm');
            
            // Hoàn thành đơn hàng
            Route::post('/order/complete', [AdminOrderController::class, 'completedOrderByAdmin'])->name('admin.order.complete');
            
            // Gửi hóa đơn 
            Route::post('/order/send-invoice', [AdminOrderController::class, 'sendInvoice'])->name('admin.order.send-invoice');
            
            // Hủy đơn hàng
            Route::post('/order/canceled', [AdminOrderController::class, 'cancelOrderInDetail'])->name('admin.order.cancel');
        });

        Route::middleware(['permission:manage_contacts'])->group(function () {
            // *********************
            //  Quản lý liên hệ
            // *********************

            // Hiển thị danh sách liên hệ
            Route::get('/contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index');
            
            // Gửi phản hồi liên hệ
            Route::post('/contact/send-reply', [AdminContactController::class, 'replyContact'])->name('admin.contact.send-reply');
        });
    });
});
