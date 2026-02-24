<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn #{{ $order->id }}</title>
</head>

<body style="margin:0; padding:0; background:#f1f8f4; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <table width="700" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#2e7d32; padding:30px; text-align:center;">

                            <h2 style="color:#ffffff; margin-top:15px;">
                                HÓA ĐƠN ĐẶT HÀNG
                            </h2>
                        </td>
                    </tr>

                    <!-- GREETING -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="margin:0 0 10px;">
                                Xin chào <strong>{{ $order->user->name }}</strong>,
                            </p>
                            <p style="margin:0;">
                                Cảm ơn bạn đã tin tưởng mua sắm tại
                                <strong style="color:#2e7d32;">Fresh_Home</strong>.
                            </p>

                            <div style="margin-top:20px;">
                                <strong>Mã đơn hàng:</strong> #{{ $order->id }} <br>
                                <strong>Ngày tạo:</strong>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>

                            <!-- STATUS BADGE -->
                            @php
                                $statusColors = [
                                    'pending' => '#f9a825',
                                    'processing' => '#1e88e5',
                                    'completed' => '#2e7d32',
                                    'canceled' => '#c62828'
                                ];

                                $statusText = [
                                    'pending' => 'Chờ xử lý',
                                    'processing' => 'Đang xử lý',
                                    'completed' => 'Hoàn thành',
                                    'canceled' => 'Đã hủy'
                                ];
                            @endphp

                            <div style="margin-top:15px;">
                                <span style="
                                    display:inline-block;
                                    padding:7px 16px;
                                    border-radius:30px;
                                    font-size:13px;
                                    color:#ffffff;
                                    background:{{ $statusColors[$order->status] ?? '#777' }};
                                ">
                                    {{ $statusText[$order->status] ?? 'Không xác định' }}
                                </span>
                            </div>

                            <h4>Phương thức thanh toán:
                                @if ($order->payment && $order->payment->payment_method == 'paypal')
                                    <span class="badge bg-warning">PayPal</span>
                                @elseif($order->payment && $order->payment->payment_method == 'cash')
                                    <span class="badge bg-info">Thanh toán khi nhận hàng</span>
                                @else
                                    <span class="badge bg-danger">Chưa xác định</span>
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
                        </td>
                    </tr>

                    <!-- DISCOUNT BANNER -->
                    @if($order->coupon)
                        <tr>
                            <td style="padding:0 30px 25px;">
                                <div style="
                                    background:#43a047;
                                    color:#ffffff;
                                    padding:18px;
                                    border-radius:8px;
                                    text-align:center;
                                    font-weight:bold;
                                ">
                                    Bạn đã sử dụng mã giảm giá
                                    <span style="font-size:16px;">
                                        {{ $order->coupon->code }}
                                    </span>
                                    và tiết kiệm
                                    {{ number_format($order->discount_amount, 0, ',', '.') }} đ
                                </div>
                            </td>
                        </tr>
                    @endif

                    <!-- SHIPPING INFO -->
                    <tr>
                        <td style="padding:0 30px 25px;">
                            <h3 style="color:#2e7d32; border-bottom:2px solid #e8f5e9; padding-bottom:8px;">
                                Thông tin giao hàng
                            </h3>

                            <p style="margin-top:10px; line-height:1.6;">
                                <strong>Họ tên:</strong>
                                {{ $order->shippingAddress->full_name }} <br>

                                <strong>Email:</strong>
                                {{ $order->user->email }} <br>

                                <strong>SĐT:</strong>
                                {{ $order->shippingAddress->phone }} <br>

                                <strong>Địa chỉ:</strong>
                                {{ $order->shippingAddress->address }},
                                {{ $order->shippingAddress->city }}
                            </p>
                        </td>
                    </tr>

                    <!-- ORDER TABLE -->
                    <tr>
                        <td style="padding:0 30px 30px;">
                            <h3 style="color:#2e7d32; border-bottom:2px solid #e8f5e9; padding-bottom:8px;">
                                Chi tiết đơn hàng
                            </h3>

                            <table width="100%" cellpadding="12" cellspacing="0"
                                style="border-collapse:collapse; text-align:center; margin-top:10px;">
                                <thead>
                                    <tr style="background:#e8f5e9;">
                                        <th style="border:1px solid #ddd;">Sản phẩm</th>
                                        <th style="border:1px solid #ddd;">Giá</th>
                                        <th style="border:1px solid #ddd;">SL</th>
                                        <th style="border:1px solid #ddd;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td style="border:1px solid #eee;">
                                                {{ $item->product->name }}
                                            </td>
                                            <td style="border:1px solid #eee;">
                                                {{ number_format($item->price, 0, ',', '.') }} đ
                                            </td>
                                            <td style="border:1px solid #eee;">
                                                {{ $item->quantity }}
                                            </td>
                                            <td style="border:1px solid #eee; font-weight:bold;">
                                                {{ number_format($item->quantity * $item->price, 0, ',', '.') }} đ
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- TOTAL -->
                    <tr>
                        <td style="padding:0 30px 30px;">
                            <table width="100%" cellpadding="8">
                                <tr>
                                    <td align="right"><strong>Tổng tiền:</strong></td>
                                    <td align="right">
                                        {{ number_format($order->total_price, 0, ',', '.') }} đ
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right"><strong>Giảm giá:</strong></td>
                                    <td align="right" style="color:#c62828;">
                                        -{{ number_format($order->discount_amount, 0, ',', '.') }} đ
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right"><strong>Phí giao hàng:</strong></td>
                                    <td align="right">25.000 đ</td>
                                </tr>

                                <tr>
                                    <td align="right" style="font-size:16px;">
                                        <strong>Tổng thanh toán:</strong>
                                    </td>
                                    <td align="right" style="color:#2e7d32; font-size:20px;">
                                        <strong>
                                            {{ number_format($order->final_price, 0, ',', '.') }} đ
                                        </strong>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#2e7d32; color:#ffffff; padding:25px; text-align:center;">
                            <p style="margin:0 0 8px; font-size:15px;">
                                Fresh_Home - Nông sản sạch mỗi ngày
                            </p>
                            <p style="margin:0; font-size:13px;">
                                Ninh Kiều, Cần Thơ | 0987 654 321 <br>
                                Email: tqphu240804@gmail.com
                            </p>

                            <p style="margin-top:10px; font-size:12px; opacity:0.8;">
                                © {{ date('Y') }} Fresh_Home. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>