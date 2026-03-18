@extends('layouts.admin')

@section('title', 'Quản Lý Đơn Hàng')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Quản Lý Đơn Hàng </h3> <small>Danh sách tất cả đơn hàng </small>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Danh Sách Đơn Hàng </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <p class="text-muted font-13 m-b-30">
                                            Trang quản lý đơn hàng cho phép admin cập nhật trang thái đơn hàng và quản lý
                                            các
                                            đơn hàng một cách hiệu quả.
                                            Dữ liệu hiển thị dưới dạng bảng với các chức năng tìm kiếm, phân trang và thao
                                            tác nhanh chóng.
                                        </p>

                                        <table id="datatable-buttons" class="table table-striped table-bordered" data-order='[[ 0, "desc" ]]'
                                            style="width:100%; text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Tài khoản</th>
                                                    <th>Thông tin đặt hàng </th>
                                                    <th>Ngày đặt</th>
                                                    <th>Tổng tiền hàng</th>
                                                    <th>Mã khuyến mãi</th>
                                                    <th>Tổng giảm giá (đ)</th>
                                                    <th>Tổng thanh toán (đ)</th>
                                                    <th>Trạng thái đơn hàng</th>
                                                    <th>Trạng thái thanh toán</th>
                                                    <th>Chi tiết đơn hàng</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>
                                                            {{ $order->id }}
                                                        </td>
                                                        <td>{{ $order->user->name }}</td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#addressShippingModal-{{ $order->id }}">
                                                                {{ $order->shippingAddress->address }} -
                                                                {{ $order->shippingAddress->phone }}</a>
                                                        </td>
                                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                        <td data-order="{{ $order->total_price }}">
                                                            {{ number_format($order->total_price, 2, ',', '.') }}
                                                        </td>
                                                        <td>{{ $order->coupon_code ?? 'Không sử dụng mã khuyến mãi'  }}</td>

                                                        <td data-order="{{ $order->discount_amount }}">
                                                            {{ number_format($order->discount_amount, 2, ',', '.') }}
                                                        </td>

                                                        <td data-order="{{ $order->final_price }}">
                                                            {{ number_format($order->final_price, 2, ',', '.') }}
                                                        </td>

                                                        <td class="order-status">
                                                            @if ($order->status == 'pending')
                                                                <span class="custom-badge badge badge-warning">Đợi xác nhận</span>
                                                            @elseif($order->status == 'processing')
                                                                <span class="custom-badge badge badge-info">Đang xử lý</span>
                                                            @elseif($order->status == 'completed')
                                                                <span class="custom-badge badge badge-success">Đã hoàn thành</span>
                                                            @elseif($order->status == 'canceled')
                                                                <span class="custom-badge badge badge-danger">Đã hủy</span>
                                                            @endif
                                                        </td>
                                                        <td class="order-payment-method">
                                                            @if($order->payment && $order->payment->status == 'pending')
                                                                <span class="custom-badge badge badge-warning">Chưa thanh
                                                                    toán</span>
                                                            @elseif($order->payment && $order->payment->status == 'completed')
                                                                <span class="custom-badge badge badge-success">Đã thanh toán</span>
                                                            @elseif($order->payment && $order->payment->status == 'failed')
                                                                <span class="custom-badge badge badge-danger">Đã hủy</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                                data-target="#orderItemsModal-{{ $order->id }}">Xem</button>
                                                        </td>

                                                        <td class="position-relative">
                                                            <div class="btn-group">
                                                                <button type="button" id="dropdown-toggle-order"
                                                                    class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                                                    data-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @if ($order->status == 'pending')
                                                                        <a class="dropdown-item confirm-order"
                                                                            href="javascript:void(0)" data-id="{{ $order->id }}" data-detail-url="{{ route('admin.order-detail', ['id' => $order->id]) }}">Xác
                                                                            nhận</a>
                                                                    @endif
                                                                    @if ($order->status == 'processing')
                                                                        <a class="dropdown-item completed-order"
                                                                            href="javascript:void(0)" data-id="{{ $order->id }}" data-detail-url="{{ route('admin.order-detail', ['id' => $order->id]) }}">Hoàn thành</a>
                                                                    @endif
                                                                    <a class="dropdown-item" target="_blank"
                                                                        href="{{ route('admin.order-detail', ['id' => $order->id]) }}">Xem
                                                                        chi
                                                                        tiết</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        @foreach ($orders as $order)
                                            {{-- Model OrderItems --}}
                                            <div class="modal fade" id="orderItemsModal-{{ $order->id }}" tabindex="-1"
                                                aria-labelledby="orderItemsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="orderItemsModalLabel">Chi tiết hóa đơn
                                                            </h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3>Chi tiết đơn hàng #{{ $order->id }}</h3>
                                                            <p>Ngày đặt:
                                                                {{ $order->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y - H:i:s') }}
                                                            </p>
                                                            <h6>Trạng thái:
                                                                @if($order->status == 'pending')
                                                                    <span>Chờ xác nhận</span>
                                                                @elseif ($order->status == 'processing')
                                                                    <span>Đang xử lý</span>
                                                                @elseif ($order->status == 'completed')
                                                                    <span>Hoàn thành</span>
                                                                @elseif ($order->status == 'canceled')
                                                                    <span>Đã hủy</span>
                                                                @endif
                                                            </h6>

                                                            <h6>Phương thức thanh toán:
                                                                @if ($order->payment && $order->payment->payment_method == 'paypal')
                                                                    <span>Thanh toán PayPal</span>
                                                                @elseif($order->payment && $order->payment->payment_method == 'cash')
                                                                    <span>Thanh toán khi nhận hàng</span>
                                                                @else
                                                                    <span class="badge bg-danger">Chưa xác định</span>
                                                                @endif
                                                            </h6>

                                                            <h6>Mã giảm giá: <span
                                                                    class="badge {{ $order->coupon ? 'bg-warning' : '' }}">
                                                                    {{ $order->coupon ? $order->coupon->code : 'Không sử dụng mã giảm giá' }}
                                                                </span></h6>

                                                            <table style="border: none; width: 100%; margin-bottom: 15px;">
                                                                <tr>
                                                                    <th style="width: 30%">Số hóa đơn</th>
                                                                    <th style="width: 40%">Khách hàng</th>
                                                                    <th style="width: 30%">Ngày đặt</th>
                                                                </tr>
                                                                <tr>
                                                                    <td># {{ $order->id }}</td>
                                                                    <td>{{ $order->user->name }}</td>
                                                                    <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                                                                </tr>
                                                            </table>



                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Tên sản phẩm</th>
                                                                        <th>Số lượng</th>
                                                                        <th>Đơn giá</th>
                                                                        <th>Thành tiền</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $index = 1;
                                                                    @endphp
                                                                    @foreach ($order->orderItems as $item)
                                                                        <tr>
                                                                            <td>{{ $index++ }}</td>
                                                                            <td>{{ $item->product->name }}</td>
                                                                            <td>{{ $item->quantity }}</td>
                                                                            <td>{{ number_format($item->price, 2, ',', '.') }} VND
                                                                            </td>
                                                                            <td>{{ number_format($item->quantity * $item->price, 2, ',', '.') }}
                                                                                VND</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="addressShippingModal-{{ $order->id }}" tabindex="-1"
                                                aria-labelledby="addressShippingModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addressShippingModalLabel">Thông tin
                                                                giao hàng
                                                            </h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Người nhận: {{ $order->shippingAddress->full_name }}</p>
                                                            <p>Địa chỉ: {{ $order->shippingAddress->address }}</p>
                                                            <p>Thành phố: {{ $order->shippingAddress->city }}</p>
                                                            <p>Số điện thoại: {{ $order->shippingAddress->phone }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection