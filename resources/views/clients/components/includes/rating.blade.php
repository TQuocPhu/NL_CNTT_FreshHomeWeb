<ul>
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= floor($product->average_rating))
            <li><a href="javascript:void(0)"><i class="fas fa-star"></i></a></li>
        @elseif ($i === ceil($product->average_rating) && $product->average_rating - floor($product->average_rating) >= 0.5)
            <li><a href="javascript:void(0)"><i class="fas fa-star-half-alt"></i></a></li>
        @else
            <li><a href="javascript:void(0)"><i class="far fa-star"></i></a></li>
        @endif
    @endfor
    <li class="review-total"> <a href="javascript:void(0)"> ( {{ $product->reviews->count() }} Đánh giá )</a></li>
</ul>