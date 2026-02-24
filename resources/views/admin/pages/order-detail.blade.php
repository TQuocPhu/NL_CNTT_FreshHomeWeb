@extends('layouts.admin')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Hóa đơn</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Hóa đơn</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                        aria-expanded="false"><i class="fa fa-wrench"></i></a>

                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <section class="content invoice">
                                <!-- title row -->
                                <div class="row">
                                    <div class="  invoice-header">
                                        <h1>
                                            <i class="fa fa-globe"></i> Hóa đơn #{{ $order->id }}.
                                            <small class="pull-right">Ngày tạo: {{$order->created_at}}</small>
                                        </h1>
                                    </div>
                                </div>
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Từ
                                        <address>
                                            <strong>Fresh_Home</strong>
                                            <br>Ninh Kiều
                                            <br>Cần Thơ, Việt Nam
                                            <br>Số điện thoại: 0987654321
                                            <br>Email: tqphu240804@gmail.com
                                        </address>
                                    </div>

                                    <div class="col-sm-4 invoice-col">
                                        Đến
                                        <address>
                                            <strong>{{ $order->shippingAddress->full_name }}.</strong>
                                            <br>{{ $order->shippingAddress->address }}
                                            <br>{{ $order->shippingAddress->city }}
                                            <br>Số điện thoại: {{ $order->shippingAddress->phone }}
                                        </address>

                                    </div>

                                    <div class="col-sm-4 invoice-col">

                                        <b>Mã đơn hàng:</b> {{ $order->id }}
                                        <br>
                                        <b>Email: </b> {{ $order->user->email }}
                                        <br>
                                        <b>Tài khoản:</b> {{ $order->user->name }}
                                    </div>

                                </div>

                                <!-- Table row -->
                                <div class="row">
                                    <div class="  table">
                                        <table class="table table-striped" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Ảnh</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderItems as $item)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ $item->product->image_url }}"
                                                                alt="{{ $item->product->name }}"
                                                                style="width: 80px; border-radius: 5px;">
                                                        </td>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ number_format($item->price, 2, ',', '.') }} đ </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->quantity * $item->price, 2, ',', '.') }} đ
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-md-6">
                                        <p class="lead">Phương thức thanh toán:</p>

                                        @if ($order->payment && $order->payment->payment_method == 'paypal')
                                            <img style="width: 70px; height: 70px;"
                                                src="{{ asset('assets/clients/img/icons/paypal.webp') }}" alt="PayPal">
                                        @elseif($order->payment && $order->payment->payment_method == 'cash')
                                            <img style="width: 70px; height: 70px;"
                                                src="{{ asset('assets/clients/img/icons/buy-cash.png') }}" alt="Cash Img">
                                        @else
                                            <span class="badge bg-danger">Chưa xác định</span>
                                        @endif

                                        <h6>Mã giảm giá: <span class="badge {{ $order->coupon ? 'bg-warning' : '' }}">
                                                {{ $order->coupon ? $order->coupon->code : 'Không sử dụng mã giảm giá' }}
                                            </span></h6>

                                        <h4>Trạng thái đơn hàng:
                                            @if ($order->status == 'pending')
                                                <span class="custom-badge badge badge-warning">Đợi xác nhận</span>
                                            @elseif($order->status == 'processing')
                                                <span class="custom-badge badge badge-info">Đang xử lý</span>
                                            @elseif($order->status == 'completed')
                                                <span class="custom-badge badge badge-success">Đã hoàn thành</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="custom-badge badge badge-danger">Đã hủy</span>
                                            @endif
                                        </h4>

                                        <h4>Trạng thái thanh toán:
                                            @if($order->payment && $order->payment->status == 'pending')
                                                <span class="custom-badge badge badge-warning">Chưa thanh
                                                    toán</span>
                                            @elseif($order->payment && $order->payment->status == 'completed')
                                                <span class="custom-badge badge badge-success">Đã thanh toán</span>
                                            @elseif($order->payment && $order->payment->status == 'failed')
                                                <span class="custom-badge badge badge-danger">Đã hủy</span>
                                            @endif
                                        </h4>

                                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                            Đây là phương thức thanh toán mà khách hàng đã chọn cho đơn hàng này. Nếu là
                                            PayPal, thanh toán sẽ được
                                            xử lý trực tuyến. Nếu là thanh toán khi nhận hàng, khách hàng sẽ thanh toán trực
                                            tiếp khi nhận sản phẩm.
                                        </p>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:50%"> Tổng tiền đơn hàng:</th>
                                                        <td>{{ number_format($order->total_price - 25000, 2, ',', '.') }}
                                                            VND</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Tổng giảm giá:</th>
                                                        <td class="text-danger">
                                                            <span>-{{ $order->formatted_discount_amount }} đ</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Phí giao hàng:</th>
                                                        <td>{{ number_format(25000, 2, ',', '.') }} VND</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Tổng thanh toán:</th>
                                                        <td class="text-success"><span class="text-success">
                                                                {{ $order->formatted_final_price }} đ
                                                            </span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div>

                                        @if ($order->status != 'canceled')
                                            <button class="btn btn-default" onclick="window.print();"><i
                                                    class="fa fa-print"></i> In hóa đơn </button>
                                            <button class="btn btn-success pull-right send-invoice-email"
                                                data-id="{{ $order->id }}"><i class="fa fa-send"></i> Gửi hóa
                                                đơn </button>

                                            @if($order->status == 'pending')
                                                <button class="btn btn-danger pull-right cancel-order" style="margin-right: 5px;"
                                                    data-id="{{ $order->id }}">
                                                    <i class="fa fa-remove"></i> Hủy đơn hàng
                                                </button>
                                            @endif
                                        @else
                                            <button class="btn btn-danger" style="cursor: not-allowed;"><i
                                                    class="fa fa-info-circle"></i> Đơn hàng đã hủy</button>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection