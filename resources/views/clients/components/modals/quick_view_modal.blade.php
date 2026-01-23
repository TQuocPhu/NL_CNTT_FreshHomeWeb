<div class="ltn__modal-area ltn__quick-view-modal-area">
    <div class="modal fade" id="quick_view_modal_{{ $product->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ltn__quick-view-modal-inner">
                        <div class="modal-product-item">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="modal-product-img">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="modal-product-info">
                                        <div class="product-ratting">
                                            <ul>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                <li class="review-total"> <a href="#"> ( 95 Reviews )</a></li>
                                            </ul>
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
                                                    <a href="javascript:void(0)"
                                                        class="theme-btn-1 btn btn-effect-1 add-to-cart-btn"
                                                        title="Thêm vào giỏ hàng" data-id="{{ $product->id }}">
                                                        <i class="fas fa-shopping-cart"></i>
                                                        <span>Thêm vào giỏ hàng</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="ltn__product-details-menu-3">
                                            <ul>
                                                <li>
                                                    <a href="javascript:void(0)" title="Yêu thích"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#liton_wishlist_modal_{{ $product->id }}">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>