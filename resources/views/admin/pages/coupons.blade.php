@extends('layouts.admin')

@section('title', 'Quản lý mã giảm giá')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Quản Lý Mã Giảm Giá </h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Danh Sách Coupon </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="card-box table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Mã Coupon</th>
                                            <th>Loại</th>
                                            <th>Giá trị</th>
                                            <th>Đơn tối thiểu</th>
                                            <th>Giới hạn</th>
                                            <th>Đã dùng</th>
                                            <th>Hết hạn</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($coupons as $coupon)
                                            <tr id="coupon-row-{{ $coupon->id }}">
                                                <td><strong class="text-primary">{{ $coupon->code }}</strong></td>
                                                <td>{{ $coupon->type == 'percent' ? 'Phần trăm (%)' : 'Tiền mặt (đ)' }}</td>
                                                <td>{{ $coupon->type == 'percent' ? $coupon->value.'%' : number_format($coupon->value).'đ' }}</td>
                                                <td>{{ number_format($coupon->min_order_value) }}đ</td>
                                                <td>{{ $coupon->usage_limit ?? '∞' }}</td>
                                                <td>{{ $coupon->used_count ?? 0 }}</td>
                                                <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : 'Không' }}</td>
                                                <td>
                                                    <span class="badge {{ $coupon->is_active ? 'badge-success' : 'badge-secondary' }}">
                                                        {{ $coupon->is_active ? 'Kích hoạt' : 'Tạm dừng' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalUpdate-{{ $coupon->id }}"><i class="fa fa-edit"></i> Sửa</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm btn-delete-submit-coupon" data-id="{{ $coupon->id }}"><i class="fa fa-trash"></i> Xóa</button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="modalUpdate-{{ $coupon->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Cập nhật mã: {{ $coupon->code }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="update-coupon-form-{{ $coupon->id }}" class="form-horizontal form-label-left">
                                                                @csrf
                                                                <div class="item form-group">
                                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Mã giảm giá <span class="required">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="code" required class="form-control" value="{{ $coupon->code }}" style="text-transform: uppercase;">
                                                                    </div>
                                                                </div>

                                                                <div class="item form-group">
                                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Loại giảm giá <span class="required">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <select name="type" required class="form-control">
                                                                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Tiền mặt (VNĐ)</option>
                                                                            <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="item form-group">
                                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Giá trị giảm <span class="required">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input type="number" name="value" required class="form-control" value="{{ $coupon->value }}">
                                                                    </div>
                                                                </div>

                                                                <div class="item form-group">
                                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Áp dụng cho đơn từ <span class="required">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input type="number" name="min_order_value" required class="form-control" value="{{ $coupon->min_order_value }}">
                                                                    </div>
                                                                </div>

                                                                <div class="item form-group">
                                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Tổng lượt sử dụng</label>
                                                                    <div class="col-md-8">
                                                                        <input type="number" name="usage_limit" class="form-control" value="{{ $coupon->usage_limit }}" placeholder="Để trống nếu không giới hạn">
                                                                    </div>
                                                                </div>

                                                                <div class="item form-group">
                                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Ngày hết hạn</label>
                                                                    <div class="col-md-8">
                                                                        <input type="date" name="expires_at" class="form-control" value="{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '' }}">
                                                                    </div>
                                                                </div>

                                                                <div class="item form-group">
                                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Kích hoạt</label>
                                                                    <div class="col-md-8" style="padding-top: 8px;">
                                                                        <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                            <button type="button" class="btn btn-primary btn-update-submit-coupon" data-id="{{ $coupon->id }}">Lưu thay đổi</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection