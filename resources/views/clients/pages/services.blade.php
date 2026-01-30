@extends('layouts.client')

@section('title', 'Dịch vụ')
@section('breadcrumb', 'Dịch vụ')

@section('content')

    <div class="ltn__about-us-area pb-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 align-self-center">
                    <div class="about-us-img-wrap ltn__img-shape-left about-img-left">
                        <img src="{{ asset('assets/clients/img/gallery/1.jpg') }}" alt="Dịch vụ chuyên nghiệp">
                        <p></p>
                        <img src="{{ asset('assets/clients/img/gallery/10.jpg') }}" alt="Dịch vụ chuyên nghiệp">
                    </div>
                </div>
                <div class="col-lg-7 align-self-center">
                    <div class="about-us-info-wrap">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">// DỊCH VỤ TIN CẬY</h6>
                            <h1 class="section-title">Chúng tôi tận tâm & <br> Chuyên nghiệp<span>.</span></h1>
                            <p>FreshHome không chỉ bán sản phẩm, chúng tôi cung cấp giải pháp cho bữa ăn sạch và tiện lợi cho mọi gia đình.</p>
                        </div>
                        <div class="about-us-info-wrap-inner about-us-info-devide">
                            <p>Với quy trình kiểm soát nghiêm ngặt từ nông trại đến bàn ăn, chúng tôi cam kết mang lại những dịch vụ hậu mãi và chăm sóc khách hàng tốt nhất trong ngành thực phẩm hữu cơ.</p>
                            <div class="list-item-with-icon">
                                <ul>
                                    <li><a href="{{ route('contact.index') }}">Giao hàng miễn phí 24/7</a></li>
                                    <li><a href="#">Đội ngũ chuyên gia tư vấn</a></li>
                                    <li><a href="#">Sản phẩm đạt chuẩn VietGAP</a></li>
                                    <li><a href="{{ route('products.index') }}">Danh mục hàng hóa đa dạng</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ltn__service-area section-bg-1 pt-115 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title">Dịch vụ của chúng tôi</h1>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="#"><img src="{{ asset('assets/clients/img/service/1.jpg') }}" alt="Rau củ hữu cơ"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="#">Rau củ Hữu cơ</a></h3>
                            <p>Cung cấp các loại rau xanh được trồng theo phương pháp tự nhiên, không hóa chất.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="#"><img src="{{ asset('assets/clients/img/service/2.jpg') }}" alt="Trái cây tươi"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="#">Trái cây Tươi sạch</a></h3>
                            <p>Trái cây đặc sản các vùng miền và nhập khẩu, đảm bảo độ tươi ngon mỗi ngày.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="#"><img src="{{ asset('assets/clients/img/service/3.jpg') }}" alt="Sữa sạch"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="#">Sữa & Sản phẩm từ sữa</a></h3>
                            <p>Nguồn sữa tươi nguyên chất có nguồn gốc rõ ràng được nhập về từ các trang trại đạt chuẩn quốc tế.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="#"><img src="{{ asset('assets/clients/img/service/3.jpg') }}" alt="Hải sản tươi sống"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="#">Hải sản Tươi sống</a></h3>
                            <p>Cung cấp các loại cá và hải sản đánh bắt trong ngày, giữ trọn vẹn hương vị biển cả tinh khiết.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="#"><img src="{{ asset('assets/clients/img/service/1.jpg') }}" alt="Thịt sạch tươi"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="#">Thịt sạch Tươi ngon</a></h3>
                            <p>Thịt heo, bò, gà đạt chuẩn an toàn vệ sinh, không chất tăng trọng và có nguồn gốc rõ ràng.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="#"><img src="{{ asset('assets/clients/img/service/2.jpg') }}" alt="Nhu yếu phẩm"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="#">Hàng Nhu yếu phẩm</a></h3>
                            <p>Gạo sạch, nước mắm truyền thống và các loại dầu ăn tốt cho sức khỏe của mọi thành viên gia đình.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ltn__our-journey-area bg-image bg-overlay-theme-90 pt-280 pb-350 mb-35 plr--9"
        data-bg="{{ asset('assets/clients/img/bg/8.jpg') }}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__our-journey-wrap">
                        <ul>
                            <li><span class="ltn__journey-icon">2015</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/31.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Khởi đầu hành trình</h3>
                                                <p>Thành lập cửa hàng nhỏ đầu tiên tại trung tâm thành phố.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="active"><span class="ltn__journey-icon">2020</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/32.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Mở rộng trang trại</h3>
                                                <p>Sở hữu 10 hecta đất canh tác nông nghiệp hữu cơ tại Đà Lạt.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li><span class="ltn__journey-icon">2024</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/33.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Chạm mốc 50 chi nhánh</h3>
                                                <p>Trở thành đơn vị cung cấp thực phẩm sạch hàng đầu khu vực.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection