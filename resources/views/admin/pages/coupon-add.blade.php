@extends('layouts.admin')

@section('title', 'Thêm mã giảm giá mới')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Thêm Mã Giảm Giá Mới </h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Thông tin Coupon</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form action="{{ route('admin.coupon.add-post') }}" id="add-coupon" method="post"
                                class="form-horizontal form-label-left">
                                @csrf
                                
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="coupon-code">Mã giảm giá
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="coupon-code" required="required" name="code"
                                            placeholder="Ví dụ: GIAM20K, SUMMER2024..."
                                            style="text-transform: uppercase;"
                                            value="{{ old('code') }}"
                                            class="form-control @error('code') is-invalid @enderror">
                                        @error('code')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="coupon-type">Loại giảm giá
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select name="type" id="coupon-type" required="required"
                                            class="form-control @error('type') is-invalid @enderror">
                                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Tiền mặt (VNĐ)</option>
                                            <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="coupon-value">Giá trị giảm
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="coupon-value" name="value" required="required"
                                            value="{{ old('value') }}"
                                            class="form-control @error('value') is-invalid @enderror">
                                        @error('value')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="min-order-value">Áp dụng cho đơn từ
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="min-order-value" name="min_order_value" required="required"
                                            value="{{ old('min_order_value', 0) }}"
                                            class="form-control @error('min_order_value') is-invalid @enderror">
                                        @error('min_order_value')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="usage-limit">Tổng lượt sử dụng
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="usage-limit" name="usage_limit"
                                            value="{{ old('usage_limit') }}" placeholder="Để trống nếu không giới hạn"
                                            class="form-control @error('usage_limit') is-invalid @enderror">
                                        @error('usage_limit')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="expires-at">Ngày hết hạn
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="date" id="expires-at" name="expires_at"
                                            value="{{ old('expires_at') }}"
                                            class="form-control @error('expires_at') is-invalid @enderror">
                                        @error('expires_at')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Kích hoạt ngay</label>
                                    <div class="col-md-6 col-sm-6 " style="padding-top: 8px;">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>

                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button class="btn btn-primary btn-reset-form" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success">Thêm mã giảm giá </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection