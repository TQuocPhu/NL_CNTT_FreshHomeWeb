<div class="ltn__modal-area ltn__add-to-cart-modal-area">
    <div class="modal fade" id="liton_wishlist_modal_{{ $product->id }}" tabindex="-1">
        <div class="modal-dialog modal-md" role="document">
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
                                <div class="col-12">
                                    <div class="modal-product-img">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="modal-product-info">
                                        <h5><a
                                                href="{{ route('product.detail', $product->slug) }}">{{$product->name}}</a>
                                        </h5>
                                        <p class="added-cart"><i class="fa fa-check-circle"></i> Thêm vào danh sách yêu thích</p>
                                        <div class="btn-wrapper">
                                            <a href="{{ route('wishlist.index') }}" class="theme-btn-1 btn btn-effect-1">Xem</a>
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