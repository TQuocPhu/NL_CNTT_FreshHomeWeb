@extends('layouts.client')

@section('title', 'Chi tiết đơn hàng')
@section('breadcrumb', 'Chi tiết đơn hàng')

@section('content')

    <div class="liton__shoping-cart-area mb-100">
        <div class="container mt-4">
            <h3>Chi tiết đơn hàng #{{ $order->id }}</h3>
            <p>Ngày đặt: {{ $order->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y - H:i:s') }}</p>
            <h6>Trạng thái:
                @if($order->status == 'pending')
                    <span class="badge bg-warning">Chờ xác nhận</span>
                @elseif ($order->status == 'processing')
                    <span class="badge bg-primary">Đang xử lý</span>
                @elseif ($order->status == 'completed')
                    <span class="badge bg-success">Hoàn thành</span>
                @elseif ($order->status == 'canceled')
                    <span class="badge bg-danger">Đã hủy</span>
                @endif
            </h6>

            <h6>Phương thức thanh toán:
                @if ($order->payment && $order->payment->payment_method == 'paypal')
                    <img style="width: 70px; height: 70px;" src="{{ asset('assets/clients/img/icons/paypal.webp') }}"
                        alt="PayPal">
                @elseif($order->payment && $order->payment->payment_method == 'cash')
                    <img style="width: 70px; height: 70px;" src="{{ asset('assets/clients/img/icons/buy-cash.png') }}"
                        alt="Cash Img">
                @else
                    <span class="badge bg-danger">Chưa xác định</span>
                @endif
            </h6>

            <h6>Mã giảm giá: <span class="badge {{ $order->coupon ? 'bg-primary' : 'bg-secondary' }}">
                    {{ $order->coupon ? $order->coupon->code : 'Không sử dụng mã giảm giá' }}
                </span></h6>

            <h4 class="mt-4">Sản phẩm trong đơn hàng</h4>

            <table class="table">
                <thead>
                    <tr>
                        <th>Ảnh sản phẩm</th>
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
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-fluid"
                                    width="80">
                            </td>
                            <td>{{ $item->product->name }}</td>

                            <td>
                                {{ number_format($item->price, 2, ',', '.') }} đ
                            </td>

                            <td>{{ $item->quantity }}</td>
                            <td>
                                {{ number_format($item->price * $item->quantity, 2, ',', '.') }} đ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="order-detail-summary mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span>Tổng tiền đơn hàng (Tiền sản phẩm + Tiền ship 25.000 đ)</span>
                    <span>{{ $order->formatted_total_price }} đ</span>
                </div>

                <div class="d-flex justify-content-between mb-2 text-danger">
                    <span>Giảm giá</span>
                    <span>-{{ $order->formatted_discount_amount }} đ</span>
                </div>
                <div></div>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Tổng thanh toán</span>
                    <span class="text-success">
                        {{ $order->formatted_final_price }} đ
                    </span>
                </div>
            </div>

            <h4 class="mt-4 mb-3">Thông tin giao hàng</h4>

            <div class="shipping-info">
                <p>
                    <strong>Người nhận:</strong>
                    <span>{{ optional($order->shippingAddress)->full_name ?? '—' }}</span>
                </p>
                <p>
                    <strong>Địa chỉ:</strong>
                    <span>{{ optional($order->shippingAddress)->address ?? '—' }}</span>
                </p>
                <p>
                    <strong>Thành phố:</strong>
                    <span>{{ optional($order->shippingAddress)->city ?? '—' }}</span>
                </p>
                <p>
                    <strong>Số điện thoại:</strong>
                    <span>{{ optional($order->shippingAddress)->phone ?? '—' }}</span>
                </p>
            </div>

            @if ($order->status == 'pending')
                <form action="{{ route('order.cancel', $order->id) }}" method="post"
                    onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này ?')">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm mt-3">Hủy đơn hàng</button>
                </form>
            @endif

            @if ($order->status == 'processing')
                <form action="{{ route('order.completed', $order->id)}} " method="post">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm mt-3">Đã nhận được hàng</button>
                </form>
            @endif

            @if ($order->status == 'canceled')
                <button disabled class="btn btn-danger btn-sm mt-3">Đơn hàng đã hủy</button>
            @endif

            @if ($order->status == 'completed')
                <h4 class="mt-4">Đánh giá sản phẩm</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                
                                <td>
                                    @if (!in_array($item->product->id, $reviewedProductIds))
                                        <a href="{{ route('product.detail', $item->product->slug) }}"
                                            class="btn theme-btn-1 btn-effect-1">Đánh giá</a>
                                    @else
                                        <span class="badge bg-success">Đã đánh giá</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection