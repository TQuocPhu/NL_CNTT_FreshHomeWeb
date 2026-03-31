<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Flasher\Toastr\Prime\toastr;

class OrderController extends Controller
{
    public function showOrderDetail($id)
    {
        $order = Order::with(['orderItems.product', 'user', 'shippingAddress', 'payment', 'coupon'])->findOrFail($id);
        $user = Auth::user();

        $reviewedProductIds = Review::where('user_id', Auth::id())
        ->pluck('product_id')
        ->toArray();

        return view('clients.pages.order-detail', compact('order', 'reviewedProductIds'));
    }

    public function canceledOrder($id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $order = Order::where('id', $id)->where('user_id', $user->id)->with('orderItems.product')->firstOrFail();

            // Hoàn kho
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            //Hoàn coupon (nếu có)
            if ($order->coupon_id) {
                Coupon::where('id', $order->coupon_id)
                    ->where('used_count', '>', 0)
                    ->decrement('used_count');
            }

            //Cập nhật trạng thái đơn hàng
            $order->update(['status' => 'canceled']);

            //update payment
            if ($order->payment) {
                $order->payment->update([
                    'status' => 'failed'
                ]);
            }

            //Lưu lịch sử trạng thái
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'canceled',
                'changed_at' => now(),
                'note' => 'Khách hàng hủy đơn hàng'
            ]);

            DB::commit();

            toastr()->success('Đơn hàng đã được hủy thành công và sản phẩm được hoàn kho');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Không thể hủy đơn hàng. Vui lòng thử lại. Lỗi: ' . $e);
            return redirect()->back();
        }
    }

    public function completeOrder($id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $order = Order::where('id', $id)->where('user_id', $user->id)->where('status', 'processing')->firstOrFail();

            //cập nhật trạng thái đơn hàng
            $order->update(['status' => 'completed']);

            //Lưu lịch sử trạng thái
            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => 'completed',
                'changed_at' => now(),
                'note'       => 'Khách hàng xác nhận đã nhận hàng'
            ]);

            //Cập nhật payment
            $payment = $order->payment;

            if ($payment) {
                if ($payment->paid_at) {
                    $payment->update([
                        'status'  => 'completed'
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

            DB::commit();

            toastr()->success('Đã nhận đơn hàng thành công! Bạn có thể đánh giá đơn hàng này');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            toastr()->error('Không thể hoàn thành đơn hàng. Vui lòng thử lại. Lỗi: ' . $e);
            return redirect()->back();
        }
    }
}
