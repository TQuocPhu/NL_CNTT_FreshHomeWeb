<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::with([
            'user:id,name,email',
            'coupon:id,code,type,value',
            'shippingAddress:id,full_name,phone,address,city',

            'payment:id,order_id,status,payment_method',

            'orderItems:id,order_id,product_id,quantity,price',
            'orderItems.product:id,name'
        ])
            ->select([
                'id',
                'user_id',
                'total_price',
                'coupon_id',
                'coupon_code',
                'discount_amount',
                'final_price',
                'status',
                'shipping_address_id',
                'created_at'
            ])
            ->orderByDesc('id')
            ->get();

        return view('admin.pages.orders', compact('orders'));
    }

    public function showOrderDetailPage($id) {
        $orders = Order::with([
            'user:id,name,email',
            'coupon:id,code,type,value',
            'shippingAddress:id,full_name,phone,address,city',

            'payment:id,order_id,status,payment_method',

            'orderItems:id,order_id,product_id,quantity,price',
            'orderItems.product:id,name'
        ])
            ->select([
                'id',
                'user_id',
                'total_price',
                'coupon_id',
                'coupon_code',
                'discount_amount',
                'final_price',
                'status',
                'shipping_address_id',
                'created_at'
            ])
            ->find($id);

        return view('admin.pages.order-detail', compact('order'));
    }
}
