@extends('layouts.client')

@section('title', 'Liên hệ')
@section('breadcrumb', 'Liên hệ')

@section('content')

    <div class="ltn__contact-address-area mb-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                            <div class="ltn__contact-address-icon">
                                <img src="{{ asset('assets/clients/img/icons/10.png') }}" alt="Icon Image">
                            </div>
                            <h3>Địa chỉ Email</h3>
                            <p>tranquocphutv2019@gmail.com <br>
                                tqphu240804@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                            <div class="ltn__contact-address-icon">
                                <img src="{{ asset('assets/clients/img/icons/11.png') }}" alt="Icon Image">
                            </div>
                            <h3>Số điện thoại</h3>
                            <p>+84919139009 <br> +84581152263</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                            <div class="ltn__contact-address-icon">
                                <img src="{{ asset('assets/clients/img/icons/12.png') }}" alt="Icon Image">
                            </div>
                            <h3>Liên hệ trực tiếp</h3>
                            <p> Ninh Kiều, Cần Thơ<br>
                                Việt Nam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ltn__contact-message-area mb-120 mb--100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ltn__form-box contact-form-box box-shadow white-bg">
                            <h4 class="title-2">Nhận báo giá</h4>
                            <form id="contact-form"
                                action="{{ route('contact.send') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-item input-item-name ltn__custom-icon">
                                            <input type="text" name="name" placeholder="Nhập họ và tên" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-item input-item-phone ltn__custom-icon">
                                            <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-item input-item-email ltn__custom-icon">
                                            <input type="email" name="email" placeholder="Nhập địa chỉ email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-item input-item-textarea ltn__custom-icon">
                                    <textarea name="message" placeholder="Nhập nội dung tin nhắn"></textarea>
                                </div>
                                <div class="btn-wrapper mt-0">
                                    <button class="btn theme-btn-1 btn-effect-1 text-uppercase btn-send-contact" type="submit">Gửi liên hệ</button>
                                </div>
                                <p class="form-messege mb-0 mt-20"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Google Map --}}
    <div class="google-map mb-120 mt-110">

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62860.622877793416!2d105.71637037821017!3d10.034268928872693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0629f6de3edb7%3A0x527f09dbfb20b659!2zQ-G6p24gVGjGoSwgTmluaCBLaeG7gXUsIEPhuqduIFRoxqEsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1760254052886!5m2!1svi!2s"
            width="100%" height="100%" allowfullscreen="" frameborder="0" aria-hidden="false" tabindex="0">
        </iframe>

    </div>

@endsection