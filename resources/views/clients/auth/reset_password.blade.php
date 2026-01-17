@extends('layouts.client')

@section('title', 'Đặt lại mật khẩu')
@section('breadcrumb', 'Đặt lại mật khẩu')

@section('content')

    <div class="container pb-60">
        <h2>Đặt lại mật khẩu</h2>

        <div class="ltn_myaccount-tab-content-inner">
            <div class="ltn_form-box">
                <form action="{{route('password.update')}}" class="ltn__form-box contact-form-box" method="POST" id="reset-password-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <fieldset>
                        <div class="row">
                            <div class="col-md-12">

                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <input type="email" name="email" placeholder="Nhập email của bạn*" value="{{ old('email') }}" required>
                                
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <input type="password" name="password" placeholder="Mật khẩu mới*" required>
                                
                                <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu mới*" required>
                            </div>
                        </div>
                    </fieldset>

                    <div class="btn-wrapper">
                        <button class="theme-btn-1 btn btn-block" type="submit">ĐẶT LẠI MẬT KHẨU</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection