@extends('layouts.client')

@section('title', 'Quên mật khẩu')
@section('breadcrumb', 'Quên mật khẩu')

@section('content')

    <div class="container">
        <h2>Quên mật khẩu</h2>

        <div class="ltn_myaccount-tab-content-inner">
            <div class="ltn__form-box">
                <form action="{{ route('password.email') }}" class="ltn__form-box contact-form-box" method="POST" id="forgot-password-form">
                    @csrf
                    <fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <input type="email" name="email" placeholder="Nhập email của bạn*" value="{{ old('email') }}" required>
                            </div>
                        </div>
                    </fieldset>

                    <div class="btn-wrapper">
                        <button class="theme-btn-1 btn btn-block" type="submit">GỬI LIÊN KẾT ĐẶT LẠI MẬT KHẨU</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection