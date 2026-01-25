@extends('layouts.client')

@section('title', 'Giỏ hàng')
@section('breadcrumb', 'Giỏ hàng')

@section('content')

    <div class="liton__shoping-cart-area mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping-cart-inner">
                        <div class="shoping-cart-table table-responsive">
                            <table class="table cart-table">
                                <tbody>
                                    @forelse ($items as $item)
                                    <tr>
                                        <td class="cart-product-remove" data-id="{{ $item['product']->id }}"><span>x</span></td>
                                        <td class="cart-product-image">
                                            <a href="{{ route('product.detail', $item['product']->slug) }}"><img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}"></a>
                                        </td>
                                        <td class="cart-product-info">
                                            <h4><a href="{{ route('product.detail', $item['product']->slug) }}">{{ $item['product']->name }}</a></h4>
                                        </td>
                                        <td class="cart-product-price">{{ $item['product']->formatted_price }}</td>
                                        <td class="cart-product-quantity">
                                            <div class="cart-plus-minus">
                                                <div class="dec qtybutton">-</div>
                                                <input type="text" value="{{ $item['quantity'] }}" name="qtybutton" class="cart-plus-minus-box"
                                                    data-max="{{ $item['product']->stock }}" data-id="{{ $item['product']->id }}" readonly>
                                                <div class="inc qtybutton">+</div>
                                            </div>
                                        </td>
                                        <td class="cart-product-subtotal">{{ number_format($item['quantity'] * $item['product']->price, 0, ',', '.') }} đ</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Giỏ hàng của bạn đang trống</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if (!empty($items))
                        <div class="shoping-cart-total mt-50">
                            <h4>Tổng giỏ hàng</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Tổng tiền hàng</td>
                                        <td><span class="cart-total">{{ number_format($subTotal, 0, ',', '.') }} đ</span></td>
                                    </tr>
                                    <tr>
                                        <td>Phí vận chuyển</td>
                                        <td>25.000 đ</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tổng đơn hàng</strong></td>
                                        <td><strong><span class="cart-grand-total">{{ number_format($subTotal + 25000, 0, ',', '.') }} đ</span></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="btn-wrapper text-right text-end">
                                <a href="checkout.html" class="theme-btn-1 btn btn-effect-1">Đặt hàng</a>
                            </div>
                        </div>
                        @else
                            
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection