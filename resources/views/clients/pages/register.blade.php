@extends('layouts.client')

@section('title', 'Đăng ký')
@section('breadcrumb', 'Đăng ký')

@section('content')

    <div class="ltn__login-area pb-110">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area text-center">
                            <h1 class="section-title">Đăng Ký <br>Tài khoản của bạn</h1>
                            <p>Hãy tạo tài khoản để trải nghiệm mua sắm rau củ tươi ngon, nhanh chóng và tiện lợi.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="account-login-inner">
                            <form action="{{ route('register_post') }}" class="ltn__form-box contact-form-box" method="post" id="register-form">
                                @csrf
                                
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" name="name" placeholder="Họ và Tên" value="{{ old('name') }}" required>
                                

                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="email" name="email" placeholder="Email*" value="{{ old('email') }}" required>
                                
                                
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="password" name="password" placeholder="Mật khẩu*" required>
                                
                                
                                @error('confirmPassword')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="password" name="confirmPassword" placeholder="Xác nhận mật khẩu*" required>
                                
                                
                                @error('checkbox1')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="checkbox1" value="" required>
                                    Tôi đồng ý để FreshHome xử lý dữ liệu cá nhân của tôi nhằm gửi 
                                    các tài liệu tiếp thị được cá nhân hóa theo chính sách bảo mật.
                                </label>
                                

                                @error('checkbox2')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="checkbox2" value="" required>
                                    Bằng cách nhấp vào "Tạo tài khoản", tôi đồng ý với chính sách bảo mật của cửa hàng.
                                </label>
                                

                                <div class="btn-wrapper">
                                    <button class="theme-btn-1 btn reverse-color btn-block" type="submit">TẠO TÀI KHOẢN</button>
                                </div>
                            </form>
                            <div class="by-agree text-center">
                                <p>Bằng cách tạo tài khoản, bạn đồng ý với các:</p>
                                <p><a href="#">ĐIỀU KHOẢN & ĐIỀU KIỆN &nbsp; &nbsp; | &nbsp; &nbsp; CHÍNH SÁCH BẢO MẬT</a></p>
                                <div class="go-to-btn mt-50">
                                    <a href="{{ route('login') }}">BẠN ĐÃ CÓ TÀI KHOẢN ?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection