<div class="ltn__product-tab-content-inner ltn__product-grid-view">
    <div class="row">
        @foreach ($products as $product)
            <div class="col-xl-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="{{ route('product.detail', $product->slug) }}"><img src="{{ $product->image_url }}" alt="{{ $product->name }}"></a>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="javascript:void(0)" title="Xem nhanh" data-bs-toggle="modal"
                                        data-bs-target="#quick_view_modal_{{ $product->id }}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" title="Thêm vào giỏ hàng" 
                                    data-bs-toggle="modal"
                                        data-bs-target="#add_to_cart_modal_{{ $product->id }}"
                                        class="add-to-cart-btn"
                                        data-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" title="Yêu thích" data-bs-toggle="modal"
                                        data-bs-target="#liton_wishlist_modal_{{ $product->id }}" data-id="{{ $product->id }}">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            @include('clients.components.includes.rating', ['product' => $product])
                        </div>
                        <h2 class="product-title"><a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h2>
                        <div class="product-price">
                            <span>{{ $product->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@foreach ($products as $product)
    @include('clients.components.includes.include-modals')
@endforeach