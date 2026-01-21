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
     * PAGE ACCOUNT
    *****************************/

    function fetchProducts() {
        let category_id = $('.category-filter.active').data('id') || '';
        let minPrice = $(".slider-range").slider('values', 0);
        let maxPrice = $(".slider-range").slider('values', 1);
        let sort_by = $('#sort-by').val();

        let urlUpdate = '/products/filter';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            url: urlUpdate,
            type: 'GET',
            data: {
                category_id : category_id,
                min_price : minPrice,
                max_price : maxPrice,
                sort_by : sort_by
            },
            beforeSend: function () {
                $('#loading-spinner').css('display', 'flex');
                $('#liton_product_grid').css('display', 'none');
            },
            success: function (res) {
                $('#liton_product_grid').html(res.products);
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
    $('.category-filter').click(function() {
        $('.category-filter').removeClass('active');
        $(this).addClass('active');
        fetchProducts();
    });

    //Sort by
    $('#sort-by').change(function() {
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
            fetchProducts();
        }
    });
    $(".amount").val($(".slider-range").slider("values", 0) + " đ" +
        " - " + $(".slider-range").slider("values", 1) + " đ");

    
});