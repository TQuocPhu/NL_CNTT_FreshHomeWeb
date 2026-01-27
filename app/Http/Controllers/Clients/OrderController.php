<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showOrderDetail($id) {
        $order = Order::with(['orderItems.product', 'user', 'shippingAddress', 'payment', 'coupon'])->findOrFail($id);
        $user = Auth::user();
        
        return view('clients.pages.order-detail', compact('order'));
    }
}
