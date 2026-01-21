@extends('layouts.client_home')

@section('title', 'Trang chủ')

@section('content')

    <!-- SLIDER AREA START (slider-3) -->
    <div class="ltn__slider-area ltn__slider-3  section-bg-1">
        <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1">
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3 ltn__slide-item-3-normal bg-image"
                data-bg="{{ asset('assets/clients/img/bg/16.jpg') }}">
                <div class="ltn__slide-item-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <div class="slide-video mb-50 d-none">
                                            <a class="ltn__video-icon-2 ltn__video-icon-2-border"
                                                href="https://www.youtube.com/embed/ATI7vfCgwXE?autoplay=1&amp;showinfo=0"
                                                data-rel="lightcase:myCollection">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div>
                                        <h6 class="slide-sub-title animated "><img
                                                src="{{ asset('assets/clients/img/icons/icon-img/1.png') }}" alt="#"> 100%
                                            Sản phẩm chính hãng & Tự nhiên</h6>
                                        <h1 class="slide-title animated">Thực phẩm <br> thiết yếu <br> Cho mọi gia đình</h1>
                                        <div class="slide-brief animated">
                                            <p>FreshHome cung cấp các loại nông sản, thực phẩm sạch và hàng tiêu dùng chọn
                                                lọc,
                                                mang hương vị thuần khiết đến gian bếp nhà bạn.</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="{{ route('products.index') }}" class="theme-btn-1 btn btn-effect-1 text-uppercase">Khám phá
                                                ngay</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="slide-item-img">
                                                    <img src="img/slider/21.png" alt="#">
                                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3 ltn__slide-item-3-normal bg-image"
                data-bg="{{ asset('assets/clients/img/slider/12.jpg') }}">
                <div class="ltn__slide-item-inner  text-right text-end">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <h6 class="slide-sub-title ltn__secondary-color animated">// Sạch từ tâm - Tươi mỗi
                                            ngày</h6>
                                        <h1 class="slide-title animated text-white">Thực phẩm xanh <br> Sống lành mạnh</h1>
                                        <div class="slide-brief animated">
                                            <p class="text-white">Lựa chọn những gì tốt nhất cho sức khỏe với danh mục thực
                                                phẩm tươi sống, hữu cơ được kiểm duyệt khắt khe từ FreshHome.</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="{{ route('products.index') }}" class="theme-btn-1 btn btn-effect-1 text-uppercase">Mua sắm
                                                ngay</a>
                                            <a href="{{ route('about') }}" class="btn btn-transparent btn-effect-3 theme-btn-2">VỀ
                                                CHÚNG TÔI</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="slide-item-img slide-img-left">
                                                    <img src="img/slider/22.png" alt="#">
                                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    <!-- SLIDER AREA END -->

    <!-- BANNER AREA START -->
    <div class="ltn__banner-area mt-120 mb-90">
        <div class="container">
            <div class="row ltn__custom-gutter--- justify-content-center">
                <div class="col-lg-6 col-md-6">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="{{ route('products.index') }}"><img src="{{ asset('assets/clients/img/banner/13.png') }}"
                                    alt="Banner Image"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ltn__banner-item">
                                <div class="ltn__banner-img">
                                    <a href="{{ route('products.index') }}"><img src="{{ asset('assets/clients/img/banner/2.jpg') }}"
                                            alt="Banner Image"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="ltn__banner-item">
                                <div class="ltn__banner-img">
                                    <a href="{{ route('products.index') }}"><img src="{{ asset('assets/clients/img/banner/15.png') }}"
                                            alt="Banner Image"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER AREA END -->

    <!-- CATEGORY AREA START -->
    <div class="ltn__category-area section-bg-1-- ltn__primary-bg before-bg-1 bg-image bg-overlay-theme-black-5--0 pt-115 pb-90"
        data-bg="{{ asset('assets/clients/img/bg/5.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title white-color">Danh mục sản phẩm</h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__category-slider-active slick-arrow-1">
                @foreach ($categories as $category)
                    <div class="col-12">
                        <div class="ltn__category-item ltn__category-item-3 text-center">
                            <div class="ltn__category-item-img category-img-fixed">
                                <a href="{{ route('products.index') }}">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                </a>
                            </div>
                            <div class="ltn__category-item-name">
                                <h5><a href="{{ route('products.index') }}">{{ $category->name }}</a></h5>
                                <h6>({{ $category->products->count() }} sản phẩm)</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- CATEGORY AREA END -->

    <!-- PRODUCT TAB AREA START (product-item-3) -->
    <div class="ltn__product-tab-area ltn__product-gutter pt-115 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title">Sản phẩm</h1>
                    </div>
                    <div class="ltn__tab-menu ltn__tab-menu-2 ltn__tab-menu-top-right-- text-uppercase text-center">
                        <div class="nav">
                            @foreach ($categories as $index => $category)
                                <a class="{{ $index == 0 ? 'active show' : '' }}" data-bs-toggle="tab"
                                    href="#tab_{{ $category->id }}">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-content">
                        @foreach ($categories as $index => $category)
                            <div class="tab-pane fade {{ $index == 0 ? 'active show' : '' }}" id="tab_{{ $category->id }}">
                                <div class="ltn__product-tab-content-inner">
                                    <div class="row ltn__tab-product-slider-one-active slick-arrow-1">
                                        <!-- ltn__product-item -->
                                        @foreach ($category->products as $product)
                                            <div class="col-lg-12">
                                                <div class="ltn__product-item ltn__product-item-3 text-center">
                                                    <div class="product-img">
                                                        <a href="#"><img src="{{ $product->image_url }}"
                                                                alt="{{ $product->name }}"></a>
                                                        <div class="product-hover-action">
                                                            <ul>
                                                                <li>
                                                                    <a href="#" title="Xem nhanh" data-bs-toggle="modal"
                                                                        data-bs-target="#quick_view_modal_{{ $product->id }}">
                                                                        <i class="far fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" title="Thêm vào giỏ hàng" data-bs-toggle="modal"
                                                                        data-bs-target="#add_to_cart_modal_{{ $product->id }}">
                                                                        <i class="fas fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" title="Yêu thích" data-bs-toggle="modal"
                                                                        data-bs-target="#liton_wishlist_modal_{{ $product->id }}">
                                                                        <i class="far fa-heart"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="product-ratting">
                                                            <ul>
                                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a>
                                                                </li>
                                                                <li><a href="#"><i class="far fa-star"></i></a></li>
                                                                <li class="review-total"> <a href="#"> (24)</a></li>
                                                            </ul>
                                                        </div>
                                                        <h2 class="product-title"><a
                                                                href="product-details.html">{{ $product->name }}</a></h2>
                                                        <div class="product-price">
                                                            <span>{{ $product->formatted_price }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT TAB AREA END -->

    <!-- PRODUCT AREA START (product-item-3) -->
    <div class="ltn__product-area ltn__product-gutter pt-115 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title">Sản phẩm bán chạy</h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__tab-product-slider-one-active--- slick-arrow-1">
                @foreach ($bestSellingProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-left">
                            <div class="product-img">
                                <a href="product-details.html"><img src="{{ $product->image_url }}"
                                        alt="{{ $product->name }}"></a>

                                <div class="product-hover-action">
                                    <ul>
                                        <li>
                                            <a href="#" title="Xem nhanh" data-bs-toggle="modal"
                                                data-bs-target="#quick_view_modal_{{ $product->id }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Thêm vào giỏ hàng" data-bs-toggle="modal"
                                                data-bs-target="#add_to_cart_modal_{{ $product->id }}">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Yêu thích" data-bs-toggle="modal"
                                                data-bs-target="#liton_wishlist_modal_{{ $product->id }}">
                                                <i class="far fa-heart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    <ul>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                        <li><a href="#"><i class="far fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <h2 class="product-title"><a href="product-details.html">{{ $product->name }}</a></h2>
                                <div class="product-price">
                                    <span>{{ $product->formatted_price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- PRODUCT AREA END -->

    <!-- CALL TO ACTION START (call-to-action-4) -->
    <div class="ltn__call-to-action-area ltn__call-to-action-4 bg-image pt-115 pb-120"
        data-bg="{{ asset('assets/clients/img/bg/6.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="call-to-action-inner call-to-action-inner-4 text-center">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">// Bạn cần hỗ trợ? //</h6>
                            <h1 class="section-title white-color">+ 84913193089</h1>
                        </div>
                        <div class="btn-wrapper">
                            <a href="tel:+84913193089" class="theme-btn-1 btn btn-effect-1">GỌI NGAY</a>
                            <a href="contact.html" class="btn btn-transparent btn-effect-4 white-color">LIÊN HỆ TƯ VẤN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ltn__call-to-4-img-1">
            <img src="{{ asset('assets/clients/img/bg/12.png') }}" alt="#">
        </div>
        <div class="ltn__call-to-4-img-2">
            <img src="{{ asset('assets/clients/img/bg/11.png') }}" alt="#">
        </div>
    </div>
    <!-- CALL TO ACTION END -->

@endsection