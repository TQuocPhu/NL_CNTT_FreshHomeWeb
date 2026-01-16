@extends('layouts.client')

@section('title', 'Câu hỏi thường gặp')
@section('breadcrumb', 'Câu hỏi thường gặp')

@section('content')

    <div class="ltn__faq-area mb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="ltn__faq-inner ltn__faq-inner-2">
                            <div id="accordion_2">
                                <!-- card -->
                                <div class="card">
                                    <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                        data-bs-target="#faq-item-2-1" aria-expanded="false">
                                        Làm thế nào để đặt mua sản phẩm?
                                    </h6>
                                    <div id="faq-item-2-1" class="collapse" data-parent="#accordion_2">
                                        <div class="card-body">
                                            <p>Để mua hàng tại FreshHome, bạn chỉ cần chọn sản phẩm yêu thích, thêm vào giỏ hàng và tiến hành thanh toán.
                                                Chúng tôi hỗ trợ nhiều hình thức thanh toán từ chuyển khoản Momo, Paypal đến trả tiền mặt khi nhận hàng.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- card -->
                                <div class="card">
                                    <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2"
                                        aria-expanded="true">
                                        Chính sách đổi trả và hoàn tiền như thế nào?
                                    </h6>
                                    <div id="faq-item-2-2" class="collapse show" data-parent="#accordion_2">
                                        <div class="card-body">
                                            <div class="ltn__video-img alignleft">
                                                <img src="{{ asset('assets/clients/img/bg/17.jpg') }}" alt="video popup bg image">
                                                <a class="ltn__video-icon-2 ltn__video-icon-2-small ltn__video-icon-2-border----"
                                                    href="https://www.youtube.com/embed/LjCzPp-MK48?autoplay=1&amp;showinfo=0"
                                                    data-rel="lightcase:myCollection">
                                                    <i class="fa fa-play"></i>
                                                </a>
                                            </div>
                                            <p>Vì là thực phẩm tươi sống, FreshHome hỗ trợ đổi trả ngay lập tức nếu sản phẩm 
                                                có dấu hiệu hư hỏng hoặc không đúng mô tả khi bạn kiểm tra hàng. 
                                                Vui lòng liên hệ hotline trong vòng 24h kể từ khi nhận hàng để được hỗ trợ nhanh nhất.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- card -->
                                <div class="card">
                                    <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                        data-bs-target="#faq-item-2-3" aria-expanded="false">
                                        Tôi là người mới, tôi nên bắt đầu từ đâu?
                                    </h6>
                                    <div id="faq-item-2-3" class="collapse" data-parent="#accordion_2">
                                        <div class="card-body">
                                            <p>Chào mừng bạn đến với FreshHome! Bạn có thể bắt đầu bằng việc xem qua danh mục "Sản phẩm bán chạy" hoặc 
                                                "Nông sản mới về" để chọn những thực phẩm tươi ngon nhất cho gia đình mình.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- card -->
                                <div class="card">
                                    <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                        data-bs-target="#faq-item-2-4" aria-expanded="false">
                                        Sản phẩm của FreshHome có nguồn gốc từ đâu?
                                    </h6>
                                    <div id="faq-item-2-4" class="collapse" data-parent="#accordion_2">
                                        <div class="card-body">
                                            <p>Tất cả sản phẩm của chúng tôi đều được nhập trực tiếp từ các trang trại đạt chuẩn VietGAP và GlobalGAP, 
                                                đảm bảo không thuốc trừ sâu và an toàn tuyệt đối cho sức khỏe.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- card -->
                                <div class="card">
                                    <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                        data-bs-target="#faq-item-2-5" aria-expanded="false">
                                        Thông tin cá nhân của tôi có được bảo mật không?
                                    </h6>
                                    <div id="faq-item-2-5" class="collapse" data-parent="#accordion_2">
                                        <div class="card-body">
                                            <p>FreshHome cam kết bảo mật tuyệt đối thông tin khách hàng. Chúng tôi chỉ sử dụng thông tin của bạn cho việc 
                                                giao hàng và cung cấp các chương trình khuyến mãi riêng biệt.</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="need-support text-center mt-100">
                                <h2>Bạn vẫn cần hỗ trợ? Liên hệ với chúng tôi 24/7:</h2>
                                <div class="btn-wrapper mb-30">
                                    <a href="contact.html" class="theme-btn-1 btn">Liên hệ ngay</a>
                                </div>
                                <h3><i class="fas fa-phone"></i> +84913193089</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <aside class="sidebar-area ltn__right-sidebar">
                            <!-- Newsletter Widget -->
                            <div class="widget ltn__search-widget ltn__newsletter-widget">
                                <h6 class="ltn__widget-sub-title">// Đăng ký</h6>
                                <h4 class="ltn__widget-title">Tìm kiếm câu hỏi</h4>
                                <form action="#">
                                    <input type="text" name="search" placeholder="Nhập từ khóa...">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                </form>
                                <div class="ltn__newsletter-bg-icon">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                            </div>
                            <!-- Banner Widget -->
                            <div class="widget ltn__banner-widget">
                                <a href="shop.html"><img src="{{ asset('assets/clients/img/banner/banner-3.jpg') }}" alt="Khuyến mãi mới"></a>
                            </div>

                        </aside>
                    </div>
                </div>
            </div>
        </div>

@endsection