<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function showOrderDetailPage($id)
    {
        $order = Order::with([
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

    public function confirmOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'       => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request) {
                $order = Order::lockForUpdate()->find($request->order_id);

                if (!$order) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Đơn hàng không tồn tại.'
                    ], 404);
                }

                if ($order->status !== 'pending') {
                    return response()->json([
                        'status' => false,
                        'message' => 'Chỉ có thể xác nhận đơn hàng đang chờ.'
                    ], 400);
                }

                $order->update([
                    'status' => 'processing'
                ]);

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => 'processing',
                    'changed_at' => now(),
                    'note' => 'Admin xác nhận đơn hàng'
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Xác nhận đơn hàng thành công.',
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    public function completedOrderByAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request) {
                $order = Order::lockForUpdate()
                    ->where('id', $request->order_id)
                    ->where('status', 'processing')
                    ->first();

                if (!$order) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Chỉ có thể hoàn thành đơn hàng đang xử lý.'
                    ], 400);
                }

                $order->update([
                    'status' => 'completed'
                ]);

                OrderStatusHistory::create([
                    'order_id'   => $order->id,
                    'status'     => 'completed',
                    'changed_at' => now(),
                    'note'       => 'Admin xác nhận hoàn thành đơn hàng'
                ]);

                $payment = $order->payment;

                if ($payment) {
                    if ($payment->paid_at) {
                        $payment->update([
                            'status' => 'completed'
                        ]);
                    } else {
                        $payment->update([
                            'status'  => 'completed',
                            'paid_at' => now(),
                        ]);
                    }
                } else {
                    Payment::create([
                        'order_id'       => $order->id,
                        'payment_method' => 'cash',
                        'amount'         => $order->final_price,
                        'status'         => 'completed',
                        'paid_at'        => now(),
                    ]);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Hoàn thành đơn hàng thành công.'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }
}
