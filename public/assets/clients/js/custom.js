$(document).ready(function () {

    /****************************
     * PAGE REGISTER + LOGIN
    *****************************/

    //Validate register form
    $('#register-form').submit(function (e) {
        let name = $('input[name="name"]').val();
        let email = $('input[name="email"]').val();
        let password = $('input[name="password"]').val();
        let confirmPassword = $('input[name="confirmPassword"]').val();
        let checkbox1 = $('input[name="checkbox1"]').is(':checked');
        let checkbox2 = $('input[name="checkbox2"]').is(':checked');

        let errorMessage = "";

        if (name.length < 3) {
            errorMessage += "Họ và tên phải có ít nhất 3 kí tự. <br>";
        }

        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
        if (!emailRegex.test(email)) {
            errorMessage += "Email không hợp lệ. <br>";
        }

        if (password.length < 6) {
            errorMessage += "Mật khẩu phải có ít nhất 6 kí tự. <br>";
        }

        if (password != confirmPassword) {
            errorMessage += "Mật khẩu xác nhận không khớp. <br>";
        }

        if (!checkbox1 || !checkbox2) {
            errorMessage += "Bạn phải đồng ý với điều khoản sử dụng và chính sách bảo mật.<br>";
        }

        if (errorMessage != "") {
            toastr.error(errorMessage, 'Lỗi đăng ký');
            e.preventDefault();
        }

    });

    //Validate login form
    $('#login-form').submit(function (e) {
        toastr.clear();

        let email = $('input[name="email"]').val();
        let password = $('input[name="password"]').val();


        let errorMessage = "";

        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
        if (!emailRegex.test(email)) {
            errorMessage += "Email không hợp lệ. <br>";
        }

        if (password.length < 6) {
            errorMessage += "Mật khẩu phải có ít nhất 6 kí tự. <br>";
        }

        if (errorMessage != "") {
            toastr.error(errorMessage, 'Lỗi đăng nhập');
            e.preventDefault();
        }
    });

    //Validate reset password form
    $('#reset-password-form').submit(function (e) {

        let email = $('input[name="email"]').val();
        let password = $('input[name="password"]').val();
        let confirmPassword = $('input[name="password_confirmation"]').val();


        let errorMessage = "";

        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/

        if (!emailRegex.test(email)) {
            errorMessage += "Email không hợp lệ. <br>";
        }

        if (password.length < 6) {
            errorMessage += "Mật khẩu phải có ít nhất 6 kí tự. <br>";
        }

        if (password != confirmPassword) {
            errorMessage += "Mật khẩu xác nhận không khớp. <br>";
        }

        if (errorMessage != "") {
            toastr.error(errorMessage, 'Lỗi đăng nhập');
            e.preventDefault();
        }
    });


    /****************************
     * PAGE ACCOUNT
    *****************************/

    //Click vào img => open input file
    $('.profile-pic').click(function (e) {
        $('#avatar').click();
    });

    //Chọn file ảnh => preview ảnh
    $('#avatar').change(function () {
        let input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });


    //cập nhật thông tin tài khoản
    $('#update-account').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let urlUpdate = $(this).attr('action'); //lấy đường dẫn của route

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }
        });

        $.ajax({
            url: urlUpdate,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('.btn-wrapper button').text('Đang cập nhật...').attr('disabled', true);
            },
            success: function (res) {
                if (res.success) {
                    toastr.success(res.message);

                    //Cập nhật avatar
                    if (res.avatar) {
                        $('#preview-image').attr('src', res.avatar);
                    }
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors
                $.each(errors, function (key, value) {
                    toastr.error(value[0])
                });
            },
            complete: function () {
                $('.btn-wrapper button').text('Cập nhật').attr('disabled', false);
            }
        });
    });


    // Validate form Đổi mật khẩu
    $('#change-password-form').submit(function (e) {
        e.preventDefault();
        let current_password = $('input[name="current_password"]').val().trim();
        let new_password = $('input[name="new_password"]').val().trim();
        let new_password_confirmation = $('input[name="new_password_confirmation"]').val().trim();


        let errorMessage = "";

        if (current_password.length < 6) {
            errorMessage += "Mật khẩu hiện tại phải có ít nhất 6 kí tự. <br>";
        }


        if (new_password.length < 6) {
            errorMessage += "Mật khẩu mới phải có ít nhất 6 kí tự. <br>";
        }

        if (new_password != new_password_confirmation) {
            errorMessage += "Mật khẩu mới xác nhận không khớp. <br>";
        }

        if (errorMessage != "") {
            toastr.error(errorMessage, 'Lỗi đổi mật khẩu');
            return;
        }

        let formData = $(this).serialize();
        let urlUpdate = $(this).attr('action');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }
        });

        $.ajax({
            url: urlUpdate,
            type: 'POST',
            data: formData,
            beforeSend: function () {
                $('.btn-wrapper button').text('Đang cập nhật...').attr('disabled', true);
            },
            success: function (res) {
                if (res.success) {
                    toastr.success(res.message);
                    $('#change-password-form')[0].reset();

                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors
                $.each(errors, function (key, value) {
                    toastr.error(value[0])
                });
            },
            complete: function () {
                $('.btn-wrapper button').text('Cập nhật').attr('disabled', false);
            }
        });

    });


    //Validate Thêm địa chỉ
    $('#addAddressForm').submit(function (e) {
        e.preventDefault();

        let isValid = true;

        //xóa thông báo cũ
        $('.error-message').remove();

        let full_name = $('#full_name').val().trim();
        let phone = $('#phone').val().trim();
        let address = $('#address').val().trim();
        let city = $('#city').val().trim();

        if (full_name.length < 3) {
            isValid = false;
            $('#full_name').after(
                '<p class="error-message text-danger">Họ và tên không nhỏ hơn 3 kí tự.</p>'
            )
        }

        if (address.length < 2) {
            isValid = false;
            $('#address').after(
                '<p class="error-message text-danger">Địa chỉ quá ngắn.</p>'
            )
        }

        if (city.length < 2) {
            isValid = false;
            $('#city').after(
                '<p class="error-message text-danger">Tên thành phố quá ngắn.</p>'
            )
        }

        let phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone)) {
            isValid = false;
            $('#phone').after(
                '<p class="error-message text-danger">Số điện thoại không hợp lệ.</p>'
            )
        }

        if (isValid) {
            $('#addAddressForm')[0].submit();
        }
    });


    /****************************
     * PAGE PRODUCTS
    *****************************/
    //Phân trang
    let currentPage = 1;
    $(document).on('click', '.pagination-link', function (e) {
        e.preventDefault();
        let pageUrl = $(this).attr('href');
        let page = pageUrl.split('page=')[1];
        currentPage = page;

        fetchProducts();
    });

    //load sản phẩm (kết hợp giữa price, category, sort và phân trang)
    function fetchProducts() {
        let category_id = $('.category-filter.active').data('id') || '';
        let minPrice = $(".slider-range").slider('values', 0);
        let maxPrice = $(".slider-range").slider('values', 1);
        let sort_by = $('#sort-by').val();

        let urlUpdate = 'products/filter?page=' + currentPage;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: urlUpdate,
            type: 'GET',
            data: {
                category_id: category_id,
                min_price: minPrice,
                max_price: maxPrice,
                sort_by: sort_by
            },
            beforeSend: function () {
                $('#loading-spinner').css('display', 'flex');
                $('#liton_product_grid').css('display', 'none');
            },
            success: function (res) {
                $('#liton_product_grid').html(res.products);
                $('.ltn__pagination').html(res.pagination);
            },
            error: function (xhr) {
                alert('Có lỗi xảy ra trong ajax fetchProducts');
            },
            complete: function () {
                $('#loading-spinner').css('display', 'none');
                $('#liton_product_grid').show();
            }
        });
    }

    //Danh mục
    $('.category-filter').click(function () {
        $('.category-filter').removeClass('active');
        $(this).addClass('active');
        currentPage = 1;
        fetchProducts();
    });

    //Sort by
    $('#sort-by').change(function () {
        currentPage = 1;
        fetchProducts();
    });

    //Khoảng giá
    $(".slider-range").slider({
        range: true,
        min: 0,
        max: 300000,
        values: [0, 300000],
        slide: function (event, ui) {
            $(".amount").val(ui.values[0] + " - " + ui.values[1] + " đ");
        },
        change: function (event, ui) {
            currentPage = 1;
            fetchProducts();
        }
    });
    $(".amount").val($(".slider-range").slider("values", 0) + " đ" +
        " - " + $(".slider-range").slider("values", 1) + " đ");


    /****************************
     * PAGE PRODUCT DETAIL
    *****************************/
    //tăng giảm số lượng sản phẩm trong trang chi tiết
    if (window.location.pathname != '/cart') { //trang hiện tại không phải trang cart
        $(document).on('click', '.qtybutton', function () {
            var $button = $(this);
            var $input = $button.siblings('input'); //lấy input cùng cấp với button trên
            var oldValue = parseInt($input.val());
            var maxStock = parseInt($input.data('max'));

            if ($button.hasClass('inc')) {
                if (oldValue < maxStock) {
                    $input.val(oldValue + 1);
                }
            } else if ($button.hasClass('dec')) {
                if (oldValue > 1) {
                    $input.val(oldValue - 1);
                }
            }
        });
    } else {
        $(document).on('click', '.qtybutton', function () {
            let $button = $(this);
            let $input = $button.siblings('input'); // lấy input cùng cấp button trên 
            let oldValue = parseInt($input.val());
            let maxStock = parseInt($input.data('max'));
            let productId = $input.data('id');
            let newValue = oldValue;

            if ($button.hasClass('inc') && oldValue < maxStock) {
                newValue = oldValue + 1;
            } else if ($button.hasClass('dec') && oldValue > 1) {
                newValue = oldValue - 1;
            }

            if (newValue != oldValue) {
                updateCart(productId, newValue, $input);
            }
        });
    }

    /****************************
     * CART
    *****************************/
    //Thêm sản phẩm vào giỏ hàng
    $(document).on('click', '.add-to-cart-btn', function (e) {
        e.preventDefault();

        let productId = $(this).data('id');
        let quantity = $(this).closest('li').prev().find('.cart-plus-minus-box').val();

        quantity = quantity ? quantity : 1;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: quantity
            },

            success: function (res) {
                if (res.status == true) {
                    // console.log(res.cart_count)
                    $('#quick_view_modal_' + productId).modal('hide');
                    $('#add_to_cart_modal_' + productId).modal('show');
                    $('#cart_count').text(res.cart_count);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                alert('Có lỗi xảy ra trong ajax addToCart');
            },

        });
    });

    //mini cart
    $('.mini-cart-icon').on('click', function (e) {
        $.ajax({
            url: '/mini-cart',
            type: 'GET',
            success: function (res) {
                if (res.status) {
                    $('#ltn__utilize-cart-menu .ltn__utilize-menu-inner').html(res.html);
                    $('#ltn__utilize-cart-menu').addClass('ltn__utilize-open');
                }
            },
            error: function (xhr) {
                toastr.error('Không thể load mini cart');
            }
        });
    });

    //xóa sản phẩm khỏi giỏ hàng trong mini cart
    $(document).on('click', '.mini-cart-item-delete', function () {

        let productId = $(this).data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/cart/remove',
            type: 'POST',
            data: {
                product_id: productId,
            },

            success: function (res) {
                if (res.status == true) {
                    // console.log(res);
                    $('#cart_count').text(res.cart_count);
                    $('#ltn__utilize-cart-menu .ltn__utilize-menu-inner').html(res.html);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                alert('Có lỗi xảy ra trong ajax removeFormMiniCart');
            },

        });
    });

    //Tắt mini cart
    $(document).on('click', '.ltn__utilize-close', function (e) {
        $('#ltn__utilize-cart-menu').removeClass('ltn__utilize-open');
        $('.ltn__utilize-overlay').hide();
    });


    /****************************
     * PAGE CART
    *****************************/

    function updateCart(productId, quantity, $input) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/cart/update',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
            },
            success: function (res) {
                $input.val(res.quantity);
                $input.closest('tr')
                    .find('.cart-product-subtotal')
                    .text(res.item_subtotal + ' VND');

                $('.cart-total').text(res.total + ' VND');
                $('.cart-grand-total').text(res.grandTotal + ' VND');
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    }

    //remove cart trong trang giỏ hàng
    $('.cart-product-remove').on('click', function (e) {
        let product_id = $(this).data('id');
        let row = $(this).closest('tr');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/cart/remove-cart',
            method: 'POST',
            data: {
                product_id: product_id,
            },
            success: function (res) {
                row.remove();

                $('.cart-total').text(res.total + ' VND');
                $('.cart-grand-total').text(res.grandTotal + ' VND');

                if (res.empty) location.reload();
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    });


    /****************************
     * PAGE CHECKOUT
    *****************************/
    //lấy danh sách địa chỉ của tài khoản
    $('#list_address').change(function (e) {
        let address_id = $(this).val();

        $.ajax({
            url: '/checkout/get-address',
            method: 'GET',
            data: {
                address_id: address_id,
            },
            success: function (res) {
                if (res.success) {
                    $('input[name="ltn__name"]').val(res.data.full_name);
                    $('input[name="ltn__phone"]').val(res.data.phone);
                    $('input[name="ltn__address"]').val(res.data.address);
                    $('input[name="ltn__city"]').val(res.data.city);
                    $('input[name="address_id"]').val(res.data.id);
                }
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    });


    // apply mã khuyến mãi
    $('#apply_coupon_btn').on('click', function (e) {
        let code = $('input[name="coupon_code"]').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/checkout/apply-coupon',
            method: 'POST',
            data: {
                coupon_code: code,
            },
            success: function (res) {
                if (!res.success) {
                    toastr.error(res.message);
                    return;
                }

                $('#discount_amount').text(res.discount + ' đ');
                $('#final_price').text(res.final_price + ' đ');

                if (!$('#cancel_coupon_btn').length) {
                    $('.coupon-wrapper').append(`
                        <button type="button" id="cancel_coupon_btn" class="btn btn-danger">
                            Hủy
                        </button>
                    `);
                }
                toastr.success(res.message);
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    });

    //Hủy coupon
    $(document).on('click', '#cancel_coupon_btn', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/checkout/cancel-coupon',
            method: 'POST',

            success: function (res) {
                $('#discount_amount').text('0 đ');
                $('#final_price').text(res.totalPrice + ' đ');
                $('input[name="coupon_code"]').val('');
                $('#cancel_coupon_btn').remove();
                toastr.info('Đã hủy mã khuyến mãi');
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    });

    //Đặt hàng
    // render button
    function togglePayment() {
        if ($('#payment_paypal').is(':checked')) {
            $('#paypal-button-container').show()
            $('#order_button_cash').hide()
        } else {
            $('#paypal-button-container').hide();
            $('#order_button_cash').show();
        }
    }

    togglePayment()

    $('input[name="payment_method"]').on('change', togglePayment);

    let finalCheckoutPrice = window.BASE_CHECKOUT_PRICE;

    // ===============================
    // APPLY COUPON - cập nhật giá PayPal
    // ===============================
    $('#apply_coupon_btn').on('click', function () {
        let code = $('input[name="coupon_code"]').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/checkout/apply-coupon',
            method: 'POST',
            data: {
                coupon_code: code
            },
            success: function (res) {
                if (!res.success) {
                    toastr.error(res.message);
                    return;
                }

                $('#discount_amount').text(res.discount + ' đ');
                $('#final_price').text(res.final_price + ' đ');

                // CẬP NHẬT GIÁ PAYPAL
                finalCheckoutPrice = parseFloat(
                    res.final_price.replace(/\./g, '')
                );

                toastr.success(res.message);
            }
        });
    });

    // ===============================
    // CANCELED COUPON - cập nhật giá PayPal
    // ===============================
    $(document).on('click', '#cancel_coupon_btn', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });
        $.ajax({
            url: '/checkout/cancel-coupon',
            method: 'POST',
            success: function (res) {
                finalCheckoutPrice = res.totalPrice;
                $('#discount_amount').text('0 đ');
                $('#final_price').text(finalCheckoutPrice.toLocaleString('vi-VN') + ' đ');
                $('input[name="coupon_code"]').val('');
                toastr.info('Đã hủy mã khuyến mãi');
            }
        });
    });

    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [
                    {
                        amount: {
                            // DÙNG GIÁ SAU COUPON
                            value: (finalCheckoutPrice / 26304).toFixed(2),
                        }
                    }
                ]
            });
        },

        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {

                fetch("/checkout/paypal", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    body: JSON.stringify({
                        orderID: data.orderID,
                        payerID: data.payerID,
                        transactionID: details.id,
                        amount: details.purchase_units[0].amount.value,
                        address_id: $("#list_address").val(),
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "/account";
                            toastr.success("Thanh toán thành công");
                        } else {
                            toastr.error("Có lỗi xảy ra, vui lòng thử lại");
                        }
                    });

            });
        }
    }).render('#paypal-button-container');

    /****************************
     * REVIEW PRODUCT
    *****************************/

    // ===============================
    // CHỈNH SỬA RATING
    // ===============================
    let selectedRating = 0

    //hover star
    $(".rating-star").hover(function() {
        let value = $(this).data("value");
        highlightStars(value);
    }, function() {
        highlightStars(selectedRating);
    });


    $(".rating-star").click(function(e) {
        e.preventDefault();
        selectedRating = $(this).data("value");
        $("#rating-value").val(selectedRating);
        highlightStars(selectedRating);
    });

    function highlightStars(value) {
        $(".rating-star i").each(function() {
            let starValue = $(this).parent().data("value");
            if(starValue <= value) {
                $(this).removeClass("far").addClass("fas");
            } else {
                $(this).removeClass("fas").addClass("far");
            }
        });
    }

    //Xử lý submit form với ajax
    $("#review-form").submit(function(e) {
        e.preventDefault();

        let product_id = $(this).data("product-id");
        let rating = $("#rating-value").val();
        let comment  = $("#review-content").val();

        if(rating === 0) {
            toastr.error('Vui lòng chọn số sao đánh giá');
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.ajax({
            url: '/review',
            method: 'POST',
            data: {
                product_id: product_id,
                rating: rating,
                comment: comment,
            },
            beforeSend: function() {
                $(".submit-review").text("Đang gửi đánh giá ...");
            },
            success: function (res) {
                $('#review-content').val("");
                selectedRating = 0;
                highlightStars(0);
                $(".ltn__comment-reply-area").hide();
                toastr.success(res.message);
                
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            },
            complete: function() {
                $(".submit-review").text("Gửi");
            }
        });
    });

});