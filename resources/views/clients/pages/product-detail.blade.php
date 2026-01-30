@extends('layouts.client')

@section('title', 'Chi tiết sản phẩm')
@section('breadcrumb', 'Chi tiết sản phẩm')

@section('content')

    <div class="ltn__shop-details-area pb-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="ltn__shop-details-inner mb-60">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ltn__shop-details-img-gallery">
                                    <div class="ltn__shop-details-large-img">
                                        @foreach ($product->images as $item)
                                            <div class="single-large-img">
                                                <a href="{{ asset('storage/' . $item->image) }}"
                                                    data-rel="lightcase:myCollection">
                                                    <img src="{{ asset('storage/' . $item->image) }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="ltn__shop-details-small-img slick-arrow-2">
                                        @foreach ($product->images as $item)
                                            <div class="single-small-img">
                                                <img src="{{asset('storage/' . $item->image)}}" alt="{{$product->name}}">
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modal-product-info shop-details-info pl-0">
                                    <div class="product-ratting">
                                        @include('clients.components.includes.rating', ['product' => $product])
                                    </div>
                                    <h3>{{ $product->name }}</h3>
                                    <div class="product-price">
                                        <span>{{ $product->formatted_price }}</span>

                                    </div>
                                    <div class="modal-product-meta ltn__product-details-menu-1">
                                        <ul>
                                            <li>
                                                <strong>Danh mục:</strong>
                                                <span>
                                                    <a href="javascript:void(0)">{{ $product->category->name }}</a>
                                                </span>
                                            </li>
                                            <li>
                                                <strong>Đơn vị tính:</strong>
                                                <span>
                                                    <a href="javascript:void(0)">{{ $product->unit }}</a>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="ltn__product-details-menu-2">
                                        <ul>
                                            <li>
                                                <div class="cart-plus-minus">
                                                    <div class="dec qtybutton">-</div>
                                                    <input type="text" value="1" name="qtybutton"
                                                        class="cart-plus-minus-box" data-max="{{ $product->stock }}"
                                                        readonly>
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="#" class="theme-btn-1 btn btn-effect-1 add-to-cart-btn"
                                                    title="Thêm vào giỏ hàng" data-id="{{ $product->id }}">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <span>Thêm vào giỏ hàng</span>
                                                </a>
                                            </li>

                                        </ul>
                                        <br>
                                        <span>Số lượng còn lại: {{ $product->stock }}</span>
                                    </div>
                                    <div class="ltn__product-details-menu-3">
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0)" title="Yêu thích" class="add-to-wishlist"
                                                    data-id="{{ $product->id }}">
                                                    <i class="far fa-heart"></i></a>
                                                <span>Yêu thích</span>
                                            </li>

                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="ltn__social-media">
                                        <ul>
                                            <li>Chia sẻ:</li>
                                            <li><a href="javascript:void(0)" title="Facebook"><i
                                                        class="fab fa-facebook-f"></i></a>
                                            </li>
                                            <li><a href="javascript:void(0)" title="Twitter"><i
                                                        class="fab fa-twitter"></i></a></li>
                                            <li><a href="javascript:void(0)" title="Linkedin"><i
                                                        class="fab fa-linkedin"></i></a>
                                            </li>
                                            <li><a href="javascript:void(0)" title="Instagram"><i
                                                        class="fab fa-instagram"></i></a>
                                            </li>

                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="ltn__safe-checkout">
                                        <h5>Đảm bảo thanh toán an toàn</h5>
                                        <img src="{{ asset('assets/clients/img/icons/payment-2.png') }}"
                                            alt="Payment Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shop Tab Start -->
                    <div class="ltn__shop-details-tab-inner ltn__shop-details-tab-inner-2">
                        <div class="ltn__shop-details-tab-menu">
                            <div class="nav">
                                <a class="active show" data-bs-toggle="tab" href="#liton_tab_details_description">Mô tả</a>
                                <a data-bs-toggle="tab" href="#liton_tab_details_reviews" class="">Đánh giá</a>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="liton_tab_details_description">
                                <div class="ltn__shop-details-tab-content-inner">
                                    <h4 class="title-2">Mô tả.</h4>
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="liton_tab_details_reviews">
                                <div class="ltn__shop-details-tab-content-inner">
                                    <h4 class="title-2">Đánh giá của khách hàng</h4>
                                    <div class="product-ratting">
                                        <ul>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($averageRating))
                                                    <li><a href="javascript:void(0)"><i class="fas fa-star"></i></a></li>
                                                @elseif ($i === ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                                    <li><a href="javascript:void(0)"><i class="fas fa-star-half-alt"></i></a></li>
                                                @else
                                                    <li><a href="javascript:void(0)"><i class="far fa-star"></i></a></li>
                                                @endif
                                            @endfor
                                            <li class="review-total"> <a href="javascript:void(0)"> (
                                                    {{ $product->reviews->count() }} Đánh giá )</a></li>
                                        </ul>
                                    </div>
                                    <hr>
                                    <!-- comment-area -->
                                    <div class="ltn__comment-area mb-30">
                                        <div class="ltn__comment-inner">
                                            @include('clients.components.includes.review-list', ['product' => $product])
                                        </div>
                                    </div>
                                    <!-- comment-reply -->
                                    @if (Auth::check() && $hasPurchased && !$hasReviewed)
                                        <div class="ltn__comment-reply-area ltn__form-box mb-30">
                                            <form id="review-form" method="post" data-product-id="{{ $product->id }}">
                                                <h4 class="title-2">Gửi đánh giá</h4>
                                                <div class="mb-30">
                                                    <div class="add-a-review">
                                                        <h6>Đánh giá của bạn:</h6>
                                                        <div class="product-ratting">
                                                            <ul>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="rating-star"
                                                                            data-value="{{ $i }}">
                                                                            <i class="far fa-star"></i>
                                                                        </a>
                                                                    </li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="rating" id="rating-value" value="0">

                                                <div class="input-item input-item-textarea ltn__custom-icon">
                                                    <textarea placeholder="Nhập đánh giá của bạn...."
                                                        id="review-content"></textarea>
                                                </div>


                                                <div class="btn-wrapper">
                                                    <button class="btn theme-btn-1 btn-effect-1 text-uppercase submit-review"
                                                        type="submit">Gửi</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shop Tab End -->
                </div>
            </div>
        </div>
    </div>
    @include('clients.components.includes.include-modals')

    <div class="ltn__product-slider-area ltn__product-gutter pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title">Sản phẩm liên quan<span>.</span></h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__related-product-slider-one-active slick-arrow-1">

                @foreach ($relatedProducts as $product)
                    <div class="col-lg-12">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="{{ route('product.detail', $product->slug) }}"><img src="{{ $product->image_url }}"
                                        alt="{{ $product->name }}"></a>

                                <div class="product-hover-action">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" title="Xem nhanh" data-bs-toggle="modal"
                                                data-bs-target="#quick_view_modal_{{ $product->id }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" title="Thêm vào giỏ hàng" class="add-to-cart-btn"
                                                data-id="{{ $product->id }}">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" title="Yêu thích" class="add-to-wishlist"
                                                data-id="{{ $product->id }}">
                                                <i class="far fa-heart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    @include('clients.components.includes.rating', ['product' => $product])
                                </div>
                                <h2 class="product-title"><a
                                        href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h2>
                                <div class="product-price">
                                    <span>{{ $product->formatted_price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
            @foreach ($relatedProducts as $product)
                @include('clients.components.includes.include-modals')
            @endforeach
        </div>
    </div>

@endsection