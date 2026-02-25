<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminAccountController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.pages.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng.'
            ], 404);
        }

        switch ($request->type) {
            // ==========================
            // CẬP NHẬT PROFILE
            // ==========================
            case 'profile':

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|min:3',
                    'phone_number' => 'required|string|max:15',
                    'address' => 'required|string',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Dữ liệu không hợp lệ.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $user->update($validator->validated());

                return response()->json([
                    'status' => true,
                    'message' => 'Cập nhật thông tin thành công!',
                ], 200);

                // ==========================
                // ĐỔI MẬT KHẨU
                // ==========================
            case 'password':

                $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|same:new_password',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Dữ liệu không hợp lệ.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Mật khẩu hiện tại không đúng.'
                    ], 422);
                }

                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Đổi mật khẩu thành công.',
                ], 200);

                // ==========================
                // CẬP NHẬT AVATAR
                // ==========================
            case 'avatar':

                if (!$request->hasFile('avatar')) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Vui lòng chọn ảnh đại diện.'
                    ], 400);
                }

                $request->validate([
                    'avatar' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);

                // Xóa ảnh cũ nếu tồn tại
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $file = $request->file('avatar');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $avatarPath = $file->storeAs('uploads/users', $fileName, 'public');

                $user->update([
                    'avatar' => $avatarPath
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Cập nhật ảnh đại diện thành công!',
                    'avatar_url' => asset('storage/' . $avatarPath),
                ], 200);

                // ==========================
                // KHÔNG HỢP LỆ
                // ==========================
            default:
                return response()->json([
                    'status' => false,
                    'message' => 'Loại yêu cầu không hợp lệ.'
                ], 400);
        }
    }
}
