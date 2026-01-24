<div class="ltn__utilize-menu-head">
    <span class="ltn__utilize-menu-title">Giỏ hàng</span>
    <button class="ltn__utilize-close">×</button>
</div>
@if(count($items))
    <div class="mini-cart-product-area ltn__scrollbar">
        @foreach ($items as $item)
            <div class="mini-cart-item clearfix">
                <div class="mini-cart-img">
                    <a href="{{ route('product.detail', $item['product']->slug) }}"><img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}"></a>
                    <span class="mini-cart-item-delete" data-id="{{ $item['product']->id }}"><i class="icon-cancel"></i></span>
                </div>
                <div class="mini-cart-info">
                    <h6><a href="{{ route('product.detail', $item['product']->slug) }}">{{ $item['product']->name }}</a></h6>
                    <span class="mini-cart-quantity">{{ $item['quantity'] }} x {{ $item['product']->formatted_price }}</span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mini-cart-footer">
        <div class="mini-cart-sub-total">
            <h5>Tổng tiền: <span>{{ number_format($subTotal, 0, ',', '.') }} VND</span></h5>
        </div>
        <div class="btn-wrapper">
            <a href="cart.html" class="theme-btn-1 btn btn-effect-1">Xem giỏ hàng</a>
            <a href="cart.html" class="theme-btn-2 btn btn-effect-2">Đặt hàng</a>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <h6 class="text-muted">Giỏ hàng của bạn đang trống</h6>
    </div>
@endif