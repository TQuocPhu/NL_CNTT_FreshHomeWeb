<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    //Hiển thị trang tài khoản
    public function index() {
        $user = Auth::user();
        return view('clients.pages.account', compact('user'));
    }

    //Chức năng cập nhật thông tin tài khoản
    public function updateProfileHandler(Request $request) {
        $request->validate(
            [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'ltn__name' => 'required|string|max:255',
                'ltn__address' => 'nullable|string|max:255',
                'ltn__phone_number' => 'nullable|string|max:15',
            ],
            [
                'avatar.image' => 'Ảnh đại diện phải là file hình ảnh.',
                'avatar.mimes' => 'Ảnh chỉ chấp nhận định dạng: jpeg, png, jpg, gif.',
                'avatar.max' => 'Ảnh không được vượt quá 2MB.',

                'ltn__name.required' => 'Họ và tên không được để trống.',
                'ltn__name.max' => 'Họ và tên không quá 255 ký tự.',

                'ltn__phone_number.max' => 'Số điện thoại không được quá 15 chữ số.',
                'ltn__address.max' => 'Địa chỉ không quá 255 ký tự.',
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();

        //Xử lý ảnh avatar
        if($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if($user->avatar && Storage::disk('public')->exists($user->avatar)){
                Storage::disk('public')->delete($user->avatar);
            }

            //Thêm ảnh mới
            $file = $request->file('avatar');
            //Tạo với tên theo thời gian thực khi tạo
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            //Lưu ảnh vào thư mục
            $avatarPath = $file->storeAs('uploads/users', $fileName, 'public');
            $user->avatar = $avatarPath;
        }

        $user->name = $request->input('ltn__name');
        $user->phone_number = $request->input('ltn__phone_number');
        $user->address = $request->input('ltn__address');

        $user->save();

        //Xử lý đường dẫn ảnh trả về ajax
        $avatarUrl = $user->avatar;

        //Có avatar không bắt đầu bằng http / https (cho tài khoản đăng ký qua form)
        if($avatarUrl && 
            !str_starts_with($avatarUrl, 'http'))
        {
            $avatarUrl = asset('storage/' . $avatarUrl);
        }


        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công',
            'avatar' => $avatarUrl,
        ]);
    }


    // Chức năng đổi mật khẩu tài khoản
    public function changePassword(Request $request) {
        $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'new_password_confirmation' => 'required|same:new_password'
            ],
            [
                'current_password.required' => 'Bạn phải nhập mật khẩu hiện tại.',
                'new_password.required' => 'Bạn phải nhập mật khẩu mới.',
                'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
                'new_password_confirmation.required' => 'Bạn phải nhập lại mật khẩu mới.',
                'new_password_confirmation.same' => 'Mật khẩu nhập lại không khớp với mật khẩu mới.'
            ]
        );

        $user = Auth::user();

        //Kiểm tra mật khẩu hiện tại đúng không => không đúng hiện lỗi 422 / đúng thì cập nhật mật khẩu mới
        if(!Hash::check($request->current_password, $user->password)){
            return response()->json([
                'errors' => ['current_password' => ['Mật khẩu hiện tại không đúng!']]
            ], 422);
        }

        //cập nhật mật khẩu mới
        $user->update(['password' => Hash::make($request->new_password)] );

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công',
        ]);
    }
}
