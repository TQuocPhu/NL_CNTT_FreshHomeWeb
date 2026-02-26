<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::select('id', 'user_id', 'message', 'link', 'is_read', 'type', 'created_at')->where('is_read', 0)->latest('created_at')->get();

        foreach ($notifications as $notification) {
            if ($notification->type === 'order') {
                $notification->title = 'Có đơn hàng mới';
            } else if ($notification->type === 'contact') {
                $notification->title = 'Có liên hệ mới';
            } else if ($notification->type === 'wishlist') {
                $notification->title = 'Sản phẩm yêu thích';
            }
        }

        return view('admin.pages.notifications', compact('notifications'));
    }

    public function read(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|integer|exists:notifications,id',
        ], [
            'notification_id.required' => 'Thiếu ID thông báo.',
            'notification_id.integer' => 'ID không hợp lệ.',
            'notification_id.exists' => 'Thông báo không tồn tại.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $notification = Notification::find($request->notification_id);

        if ($notification->is_read) {
            return response()->json([
                'status' => false,
                'message' => 'Thông báo đã được đọc trước đó.',
            ], 400);
        }

        $notification->update([
            'is_read' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đã đánh dấu đã đọc.',
        ]);
    }
}
