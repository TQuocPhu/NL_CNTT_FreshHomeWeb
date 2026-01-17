<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm() {
        return view('clients.auth.forgot-password');
    }

    public function sendResetPasswordLinkToEmail(Request $request) {
        $request->validate(
        [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.exists' => 'Email không tồn tại trong hệ thống'
            ]
        );

        $status = Password::sendResetLink($request->only('email'));

        if($status == Password::RESET_LINK_SENT) {
            toastr()->success('Liên kết đặt lại mật khẩu đã được gửi đến email của bạn.');
            return back();
        }

        toastr()->error('Không thể gửi liên kết đặt lại mật khẩu đến email của bạn.');
        return back()->withErrors(['email' => __($status)] );
    }
}
