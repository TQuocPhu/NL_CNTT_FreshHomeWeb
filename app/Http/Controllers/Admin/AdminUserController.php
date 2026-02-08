<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

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
}
