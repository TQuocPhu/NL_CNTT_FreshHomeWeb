<div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head">
            <div class="site-logo">
                <a href="{{ route('home') }}" class="ltn__secondary-color"><img
                        src="{{ asset('assets/clients/img/favicon.png') }}" alt="Logo">FreshHome</a>
            </div>
            <button class="ltn__utilize-close">×</button>
        </div>
        <div class="ltn__utilize-menu-search-form">
            <form action="#">
                <input type="text" placeholder="Search...">
                <button><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="ltn__utilize-menu">
            <ul>
                <li><a href="{{ route('home') }}">Trang chủ</a> </li>
                <li><a href="javascript:void(0)">Về chúng tôi</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('about') }}">Về chúng tôi</a></li>
                        <li><a href="{{ route('service') }}">Dịch vụ</a></li>
                        <li><a href="{{ route('team') }}">Team</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('products.index') }}">Cửa hàng</a></li>
                <li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
            </ul>
        </div>
        <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
            <ul>
                <li>
                    <a href="{{ route('account') }}" title="Tài khoản">
                        <span class="utilize-btn-icon">
                            <i class="far fa-user"></i>
                        </span>
                        Tài khoản
                    </a>
                </li>
                <li>
                    <a href="wishlist.html" title="Yêu thích">
                        <span class="utilize-btn-icon">
                            <i class="far fa-heart"></i>
                            <sup>3</sup>
                        </span>
                        Yêu thích
                    </a>
                </li>
                <li>
                    <a href="{{ route('cart.index') }}" title="Giỏ hàng">
                        <span class="utilize-btn-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <sup id="cart_count">
                                @auth
                                    {{-- {{ \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity') }} --}}
                                    {{ \App\Models\CartItem::where('user_id', auth()->id())->count() }}
                                @else
                                    {{-- {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }} --}}
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                @endauth
                            </sup>
                        </span>
                        Giỏ hàng
                    </a>
                </li>
            </ul>
        </div>
        <div class="ltn__social-media-2">
            <ul>
                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
</div>