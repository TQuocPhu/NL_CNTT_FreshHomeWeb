<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ActivationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('clients.pages.register');
    }

    public function register(Request $request)
    {
        // validate backend
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6'
            ],
            [
                'name.required' => 'Họ và tên không được để trống',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                // 'password.confirmed' => 'Xác nhận mật khẩu không khớp'
            ]
        );

        //check existed email
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {

            // trường hợp email nhập vào đã tồn tại mà chưa kích hoạt tài khoản
            if ($existingUser->isPending()) {
                toastr()->error("Email đang chờ xác nhận. Vui lòng kiểm tra email của bạn để xác nhận tài khoản.");
                return redirect()->route('register');
            }

            return redirect()->route('register');
        }

        //create token active
        $token = Str::random(64);

        //create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
            'role_id' => 3,
            'activation_token' => $token,
        ]);

        Mail::to($user->email)->send(new ActivationMail($token, $user));

        toastr()->success("Đăng ký thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.");
        return redirect()->route('login');
    }


    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if ($user) {
            $user->status = 'active';
            $user->activation_token = null;
            $user->save();

            toastr()->success('Kích hoạt tài khoản thành công');
            return redirect()->route('login');
        }

        toastr()->error('Token không hợp lệ hoặc đã hết hạn.');
        return redirect()->back();
    }

    public function showLoginForm()
    {
        return view('clients.pages.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ],
            [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            ]
        );

        //check login information
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {
            if (in_array(Auth::user()->role->name, ['customer'])) {

                $request->session()->regenerate();
                toastr()->success('Đăng nhập thành công!');

                return redirect()->route('home');
            } else {
                Auth::logout();
                toastr()->warning('Bạn không có quyền truy cập vào tài khoản này!');
                return redirect()->back();
            }
        }

        toastr()->error('Thông tin đăng nhập không hợp lệ hoặc tài khoản chưa được kích hoạt.');
        return redirect()->back();
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('Đăng xuất thành công!');

        return redirect()->route('login');
    }
}
