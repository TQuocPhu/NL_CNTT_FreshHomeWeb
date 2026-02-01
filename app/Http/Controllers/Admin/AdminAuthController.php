<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Flasher\Toastr\Prime\toastr;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.pages.login');
    }

    public function loginAdmin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('admin')->user();

            //Kiểm tra quyền
            if (in_array($user->role->name, ['admin', 'staff'])) {
                $request->session()->regenerate();
                toastr()->success('Đăng nhập admin thành công.');
                return redirect()->route('admin.dashboard');
            }

            Auth::guard('admin')->logout();
            toastr()->error('Không có quyền truy cập trang quản trị.');
            return back();
        }
        toastr()->error('Email hoặc mật khẩu không đúng.');
        return back();
    }
}
