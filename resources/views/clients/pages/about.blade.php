@extends('layouts.client')

@section('title', 'Về chúng tôi')
@section('breadcrumb', 'Về chúng tôi')

@section('content')

    <div class="ltn__about-us-area pt-120--- pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <div class="about-us-img-wrap about-img-left">
                            <img src="{{ asset('assets/clients/img/others/6.png') }}" alt="About Us Image">
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-center">
                        <div class="about-us-info-wrap">
                            <div class="section-title-area ltn__section-title-2">
                                <h6 class="section-subtitle ltn__secondary-color">Tìm hiểu về cửa hàng</h6>
                                <h1 class="section-title">Cửa hàng thực phẩm <br class="d-none d-md-block"> Hữu cơ Tin cậy</h1>
                                <p>FreshHome ra đời với sứ mệnh mang đến nguồn thực phẩm tươi sạch, an toàn cho mỗi bữa cơm gia đình Việt.</p>
                            </div>
                            <p>Chúng tôi là cộng đồng của những người sản xuất tử tế, tâm huyết với nông nghiệp sạch. 
                                Một hệ sinh thái tự vận hành dựa trên niềm tin, chất lượng sản phẩm và sự minh bạch về nguồn gốc nội dung.</p>
                            <div class="about-author-info d-flex">
                                <div class="author-name-designation  align-self-center">
                                    <h4 class="mb-0">Jerry Henson</h4>
                                    <small>/ Giám đốc điều hành</small>
                                </div>
                                <div class="author-sign">
                                    <img src="{{ asset('assets/clients/img/icons/icon-img/author-sign.png') }}" alt="#">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="ltn__feature-area section-bg-1 pt-115 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area ltn__section-title-2 text-center">
                            <h6 class="section-subtitle ltn__secondary-color">// Đặc điểm nổi bật //</h6>
                            <h1 class="section-title">Tại sao chọn chúng tôi<span>.</span></h1>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="ltn__feature-item ltn__feature-item-7">
                            <div class="ltn__feature-icon-title">
                                <div class="ltn__feature-icon">
                                    <span><img src="{{ asset('assets/clients/img/icons/icon-img/21.png') }}" alt="#"></span>
                                </div>
                                <h3><a href="#">Thương hiệu uy tín</a></h3>
                            </div>
                            <div class="ltn__feature-info">
                                <p>Chúng tôi liên kết với các đối tác nông nghiệp hàng đầu, đảm bảo tiêu chuẩn quốc tế.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="ltn__feature-item ltn__feature-item-7">
                            <div class="ltn__feature-icon-title">
                                <div class="ltn__feature-icon">
                                    <span><img src="{{ asset('assets/clients/img/icons/icon-img/22.png') }}" alt="#"></span>
                                </div>
                                <h3><a href="#">Sản phẩm chọn lọc</a></h3>
                            </div>
                            <div class="ltn__feature-info">
                                <p>Mỗi sản phẩm đều trải qua quy trình kiểm tra nghiêm ngặt trước khi đến tay bạn.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="ltn__feature-item ltn__feature-item-7">
                            <div class="ltn__feature-icon-title">
                                <div class="ltn__feature-icon">
                                    <span><img src="{{ asset('assets/clients/img/icons/icon-img/23.png') }}" alt="#"></span>
                                </div>
                                <h3><a href="#">Không hóa chất</a></h3>
                            </div>
                            <div class="ltn__feature-info">
                                <p>Cam kết thực phẩm 100% không dư lượng thuốc trừ sâu và chất bảo quản độc hại.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection