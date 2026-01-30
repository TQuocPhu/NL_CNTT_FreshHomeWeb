@extends('layouts.client')

@section('title', 'Danh sách yêu thích')
@section('breadcrumb', 'Danh sách yêu thích')

@section('content')

<div class="liton__shoping-cart-area mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <style>
                        .add-to-cart-btn:hover i {
                            transform: scale(1.2);
                            transition: transform 0.2s ease;
                        }
                    </style>
                    <div class="shoping-cart-inner">
                        <div class="shoping-cart-table table-responsive">

                            <table class="table cart-table">
                                <tbody>
                                    @forelse ($wishlist as $item)
                                        <tr>
                                            <td class="wishlist-product-remove" data-id="{{ $item->product->id }}">
                                                x
                                            </td>
                                            <td class="wishlist-product-image">
                                                <a href="{{ route('product.detail', $item->product->slug) }}"><img
                                                        src="{{ $item->product->image_url }}" alt="Sản phẩm"></a>
                                            </td>
                                            <td class="wishlist-product-info">
                                                <h4><a
                                                        href="{{ route('product.detail', $item->product->slug) }}">{{$item->product->name}}</a>
                                                </h4>
                                            </td>
                                            <td class="wishlist-product-price">
                                                {{ $item->product->formatted_price }}</td>
                                            <td class="wishlist-product-stock">
                                                {{ $item->product->status == 'in_stock' ? 'Còn hàng' : 'Hết hàng' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('product.detail', $item->product->slug) }}"
                                                    class="btn btn-light border submit-button-1 shadow-sm"
                                                    title="Thêm vào giỏ hàng" data-id="{{ $item->product->id }}">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Danh sách yêu thích của bạn đang trống.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection