<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    //Hiển thị trang tài khoản
    public function index() {
        $user = Auth::user();
        $addresses = ShippingAddress::where('user_id', $user->id)->get();
        return view('clients.pages.account', compact('user', 'addresses'));
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

    public function addAddress(Request $request) {
        $request->validate(
            [
                'full_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
            ],
            [
                'full_name.required' => 'Vui lòng nhập họ và tên.',
                'full_name.string'   => 'Họ và tên phải là chuỗi ký tự.',
                'full_name.max'      => 'Họ và tên không được vượt quá 255 ký tự.',

                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.string'   => 'Số điện thoại phải là chuỗi ký tự.',
                'phone.max'      => 'Số điện thoại không được vượt quá 20 ký tự.',

                'address.required' => 'Vui lòng nhập địa chỉ.',
                'address.string'   => 'Địa chỉ phải là chuỗi ký tự.',
                'address.max'      => 'Địa chỉ không được vượt quá 255 ký tự.',

                'city.required' => 'Vui lòng nhập tên thành phố.',
                'city.string'   => 'Tên thành phố phải là chuỗi ký tự.',
                'city.max'      => 'Tên thành phố không được vượt quá 100 ký tự.',
            ]
        );

        //Nếu db có địa chỉ của user_id đó thì thêm một địa chỉ mới (có đánh dấu mặc định) 
        // => các địa chỉ khác của user đó sẽ trở thành địa chỉ không phải mặc đinh
        if($request->has('default')) {
            ShippingAddress::where('user_id', Auth::id())->update(['default' => 0]);
        }

        // tạo bảng ghi mới trong db
        ShippingAddress::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'default' => $request->has('default') ? 1 : 0,
        ]);

        return back()->with('success', 'Địa chỉ đã được thêm!');

    }

    //Hàm chọn địa chỉ là mặc định
    public function chooseDefaultAddress($id) {
        // Tìm address có id trên tham số
        $address = ShippingAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Đặt các địa chỉ khác của user này về default = 0
        ShippingAddress::where('user_id', Auth::id())->update(['default' => 0]);

        $address->update(['default' => 1]);

        return back()->with('success', 'Địa chỉ đã được đặt là mặc định.');
    }

    // Xóa địa chỉ
    public function removeAddress($id) {
        $address = ShippingAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if(!$address) {
            return back()->with('error', 'Địa chỉ không tồn tại.');
        }

        //Nếu là địa chỉ mặc định thì không cho xóa
        if($address->default) {
            return back()->with('error', 'Không thể xóa địa chỉ mặc định.');
        }

        $address->delete();
        return back()->with('success', 'Xóa địa chỉ thành công.');
    }
}
