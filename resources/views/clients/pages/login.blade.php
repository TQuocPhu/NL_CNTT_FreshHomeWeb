@extends('layouts.client')

@section('title', 'Đăng nhập')
@section('breadcrumb', 'Đăng nhập')

@section('content')

    <div class="ltn__login-area pb-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area text-center">
                        <h1 class="section-title">Đăng nhập <br>vào tài khoản của bạn</h1>
                        <p>Vui lòng nhập thông tin đăng nhập của bạn để truy cập vào tài khoản.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="account-login-inner">
                        <form action="#" class="ltn__form-box contact-form-box" method="post" id="login-form">
                            @csrf

                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <input type="email" name="email" placeholder="Email*" required>

                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <input type="password" name="password" placeholder="Mật khẩu*" required>

                            <div class="btn-wrapper mt-0">
                                <button class="theme-btn-1 btn btn-block" type="submit">Đăng nhập</button>
                            </div>
                            <div class="go-to-btn mt-20">
                                <a href="{{ route('password.request') }}"><small>Quên mật khẩu?</small></a>
                            </div>
                        </form>
                        <div class="ltn__journey-history-img">
                            <img src="{{ asset('assets/clients/img/banner/15.png') }}" alt="#">
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="account-create text-center pt-50">
                        <div class="ltn__journey-history-img">
                            <img src="{{ asset('assets/clients/img/banner/14.png') }}" alt="#">
                        </div>
                        <hr>
                        <h4>Bạn chưa có tài khoản?</h4>
                        <p>Thêm các mục vào danh sách yêu thích của bạn và nhận các đề xuất phù hợp về các mặt hàng yêu
                            thích của mình</p>
                        <div class="btn-wrapper">
                            <a href="{{ route('register') }}" class="theme-btn-1 btn black-btn">TẠO TÀI KHOẢN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection