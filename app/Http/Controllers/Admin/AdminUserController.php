<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {

        $query = User::with('role');
        $search = $request->input('search');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%");
        }

        $users = $query->paginate(9);

        return view('admin.pages.users', compact('users'));
    }

    public function upgradedStaff(Request $request)
    {
        $userId = $request->user_id;

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng.',
            ]);
        }

        //Kiểm tra user đó có đơn hàng chưa hoàn tất không ?
        $uncompletedOrders = Order::where('user_id', $userId)
            ->whereIn('status', ['pending', 'processing'])
            ->count();

        if ($uncompletedOrders > 0) {
            return response()->json([
                'success' => false,
                'message' => "Không thể nâng cấp! Người dùng này vẫn còn $uncompletedOrders đơn hàng chưa hoàn tất.",
            ]);
        }

        $user->role_id = 2;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã nâng cấp thành công tài khoản lên nhân viên.',
        ]);
    }

    public function updateStatus(Request $request)
    {
        $userId = $request->user_id;
        $status = $request->status;

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy người dùng.']);
        }

        return DB::transaction(function () use ($user, $status, $userId) {
            $message = 'Cập nhật trạng thái thành công.';

            if ($status === 'deleted') {
                //Lấy danh sách đơn hàng cần xử lý trước khi đổi trạng thái sang xóa
                $uncompletedOrders = Order::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'processing'])
                    ->with(['orderItems.product', 'payment'])
                    ->get();

                if ($uncompletedOrders->count() > 0) {
                    /** @var \App\Models\Order $order */
                    foreach ($uncompletedOrders as $order) {

                        foreach ($order->orderItems as $item) {
                            if ($item->product) {
                                $item->product->increment('stock', $item->quantity);
                            }
                        }

                        if ($order->coupon_id) {
                            Coupon::where('id', $order->coupon_id)
                                ->where('used_count', '>', 0)
                                ->decrement('used_count');
                        }

                        if ($order->payment) {
                            $order->payment->update(['status' => 'failed']);
                        }
                        $order->update(['status' => 'canceled']);

                        OrderStatusHistory::create([
                            'order_id'   => $order->id,
                            'status'     => 'canceled',
                            'changed_at' => now(),
                            'note'       => 'Hệ thống tự động hủy do tài khoản người dùng bị xóa bởi Admin.'
                        ]);
                    }
                    $message .= " Đã tự động hủy " . $uncompletedOrders->count() . " đơn hàng chưa hoàn tất.";
                }
            } elseif ($status === 'banned') {
                $uncompletedOrders = Order::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'processing'])
                    ->count();
                if ($uncompletedOrders > 0) {
                    $message .= " Lưu ý: User này vẫn còn $uncompletedOrders đơn hàng đang xử lý.";
                }
            }

            $user->status = $status;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => $message,
                'pending_count' => $uncompletedOrders ?? 0 // Gửi thêm để JS xử lý nếu cần
            ]);
        });
    }
}
