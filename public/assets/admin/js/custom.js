$(document).ready(function () {

    const vnCurrency = new Intl.NumberFormat('vi-VN', {
        maximumFractionDigits: 2
    });

    /****************************
     * USERS MANAGEMENT
    *****************************/
    //upgrade user => staff
    $(document).on('click', '.upgradeStaff', function (e) {
        e.preventDefault();

        let button = $(this);
        let userId = button.data('userid');
        let userName = button.closest('.profile_view').find('h2').text().trim();

        // Thêm xác nhận trước khi thực hiện
        if (!confirm(`Bạn có chắc chắn muốn nâng cấp "${userName}" lên làm Nhân viên không?`)) {
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            }
        });

        $.ajax({
            url: '/admin/user/upgrade',
            type: 'POST',
            data: {
                user_id: userId,
            },
            beforeSend: function () {
                button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    button.closest('.profile_view').find('.brief i').text('STAFF');

                    let staffButtonHtml = `
                        <button type="button" class="btn btn-success btn-xs" disabled 
                                style="opacity: 1; cursor: default; font-weight: bold; text-transform: uppercase; min-width: 80px;">
                            <i class="fa fa-user-md"></i> Nhân viên
                        </button>`;
                    button.closest('.profile_view').find('.role-user-button').first().fadeOut(200, function () { $(this).html(staffButtonHtml).fadeIn(200); });
                    button.closest('.profile_view').find('.changeStatus').hide();
                    button.hide();
                } else {
                    toastr.error(response.message);
                    button.prop('disabled', false).html('<i class="fa fa-user"></i> Nhân viên');
                }
            },
            error: function (xhr, status, error) { // Thêm 3 tham số lỗi để debug tốt hơn
                // Lấy thông báo lỗi cụ thể hơn nếu có
                let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : status + ' ' + error;
                toastr.error('Lỗi: ' + errorMessage);
                console.log(xhr.responseText); // Để xem chi tiết lỗi 404/419
            }
        });
    });

    // Cập nhật trạng thái tài khoản
    $(document).on('click', '.changeStatus', function (e) {
        e.preventDefault();

        let button = $(this);
        let userId = button.data('userid');
        let newStatus = button.data('status');
        let statusName = "";
        if (newStatus === 'banned') {
            statusName = "KHÓA";
        } else if (newStatus === 'active') {
            statusName = "KÍCH HOẠT / KHÔI PHỤC";
        } else if (newStatus === 'deleted') {
            statusName = "XÓA";
        }

        let originalHtml = button.html(); //lưu html gốc của nút bấm vào

        if (!confirm(`Bạn có chắc chắn muốn ${statusName} tài khoản này không?`)) {
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            }
        });

        $.ajax({
            url: "/admin/user/update-status",
            type: "POST",
            data: {
                user_id: userId,
                status: newStatus,
            },
            beforeSend: function () {
                // Vô hiệu hóa và hiện icon xoay
                button.prop('disabled', true).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');
            },
            success: function (response) {
                if (response.status) {
                    if (response.message.includes('Lưu ý') || response.message.includes('tự động hủy')) {
                        toastr.warning(response.message, 'Thông báo hệ thống', { timeOut: 8000 });
                    } else {
                        toastr.success(response.message);
                    }

                    let profileCard = button.closest('.profile_view');

                    if (newStatus === 'banned') {
                        button.html('<i class="fa fa-lock"></i> Đã khóa');
                        button.removeClass('btn-warning').addClass('btn-secondary');
                        profileCard.find('.status-text').text('Banned').css('color', '#d9534f');
                    } else if (newStatus === 'deleted') {
                        button.html('<i class="fa fa-trash"></i> Đã xóa');
                        button.removeClass('btn-danger').addClass('btn-secondary');
                        profileCard.find('.status-text').text('Deleted').css('color', '#d9534f');
                    } else if (newStatus === 'active') {
                        button.html('<i class="fa fa-unlock-alt"> </i> Kích hoạt');
                        button.removeClass('btn-danger').addClass('btn-secondary');
                        profileCard.find('.status-text').text('Đã kích hoạt').css('color', '#26B99A');
                    }

                    button.prop("disabled", true).addClass("disabled");
                    profileCard.find('.upgradeStaff').fadeOut();
                    profileCard.find('.changeStatus').not(button).fadeOut();
                } else {
                    toastr.error(response.message);
                    button.prop('disabled', false).removeClass('disabled').html(originalHtml);
                }
            },
            error: function (xhr, status, error) {
                let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Lỗi hệ thống';
                toastr.error('Lỗi: ' + errorMessage);

                // Khôi phục nút khi có lỗi hệ thống (404, 500, v.v.)
                button.prop('disabled', false).removeClass('disabled').html(originalHtml);
            },
        });
    });


    /****************************
     * CATEGORIES MANAGEMENT
    *****************************/
    $('#category-image').change(function () {
        let file = this.files[0];
        if (file) {
            let render = new FileReader();
            render.onload = function (e) {
                $('#image-preview').attr('src', e.target.result);
            }
            render.readAsDataURL(file);
        } else {
            $('#image-preview').attr('src', '');
        }
    });

    $('.category-image-input').change(function () {
        let file = this.files[0];
        let category_id = $(this).data('id');
        if (file) {
            let render = new FileReader();
            render.onload = function (e) {
                $('.image-preview').each(function () {
                    if ($(this).closest(".modal").attr("id") === "modalUpdate-" + category_id) {
                        $(this).attr("src", e.target.result);
                    }
                });
            }
            render.readAsDataURL(file);
        } else {
            $('#image-preview').attr('src', '');
        }
    });

    //ấn nút reset
    $('.btn-reset').on('click', function (e) {
        let form = $(this).closest('form');
        form.trigger('reset');
        form.find('input[type="file"]').val('');
        // form.find('#image-preview').html('');
        form.find('#image-preview-container').empty();

        form.find('#image-preview').attr('src', '');

        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').empty().hide();
    });

    // update category
    $(document).on('click', '.btn-update-submit-category', function (e) {
        e.preventDefault();

        let button = $(this);
        let form = $(this).closest('.modal').find('form');
        let formData = new FormData(form[0]);

        let category_id = button.data('id');

        formData.append('category_id', category_id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            type: 'POST',
            url: '/admin/category/update',
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                button.prop('disabled', true);
                button.text('Đang cập nhật...');
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);
                    let category = res.data;
                    let categoryId = category.id;

                    let row = $(`#category-row-${categoryId}`);

                    if (category.image) {
                        row.find('.category-image').attr('src', category.image);
                    }

                    row.find('td:nth-child(2)').text(category.name);
                    row.find('td:nth-child(3)').text(category.slug);
                    row.find('td:nth-child(4)').text(category.description || '');

                    let modal = $(`#modalUpdate-${categoryId}`);
                    modal.find('input[name="name"]').val(category.name);
                    modal.find('input[name="description"]').val(category.description);

                    if (category.image) {
                        modal.find('.image-preview').attr('src', category.image);
                    }

                    modal.modal('hide');

                    row.addClass('table-info');
                    setTimeout(() => row.removeClass('table-info'), 2000);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    // Hiển thị lỗi đầu tiên bằng toastr
                    toastr.error(Object.values(errors)[0][0]);
                } else if (xhr.status === 404) {
                    toastr.error(xhr.responseJSON?.message || 'Không tìm thấy danh mục');
                } else {
                    toastr.error('Đã có lỗi hệ thống xảy ra.');
                }
            },
            complete: function () {
                button.prop('disabled', false).text('Chỉnh sửa');
            }
        });
    });

    $(document).on('click', '.btn-delete-submit-category', function (e) {
        e.preventDefault();

        let button = $(this);
        let category_id = button.data('id');
        let row = button.closest('tr');

        if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                type: "POST",
                url: "/admin/category/delete",
                data: {
                    category_id: category_id,
                },
                success: function (res) {
                    if (res.status) {
                        toastr.success(res.message);
                        row.fadeOut(300, function () {
                            $(this).remove();
                        });
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        // Hiển thị lỗi đầu tiên bằng toastr
                        toastr.error(Object.values(errors)[0][0]);
                    } else if (xhr.status === 400) {
                        // Đây là lỗi nghiệp vụ 
                        toastr.warning(xhr.responseJSON.message);
                    }
                    else if (xhr.status === 404) {
                        toastr.error(xhr.responseJSON?.message || 'Không tìm thấy danh mục');
                    } else {
                        toastr.error('Đã có lỗi hệ thống xảy ra.');
                    }
                }
            });
        }
    });


    /****************************
     * PRODUCTS MANAGEMENT
    *****************************/
    $('#product-images').on('change', function (e) {
        let files = e.target.files;
        let previewContainer = $('#image-preview-container');

        previewContainer.empty();

        if (files.length === 0) {
            previewContainer.append('<p>Không có ảnh nào được chọn</p>');
            return;
        }

        $.each(files, function (index, file) {
            let render = new FileReader();
            render.onload = function (e) {
                const img = $('<img>').attr('src', e.target.result)
                    .attr('alt', file.name)
                    .addClass('image-preview');
                previewContainer.append(img);
            }
            render.readAsDataURL(file);
        });
    });

    // Hiển thị xem thêm ở mô tả của danh sách sản phẩm
    $(document).on('click', '.btn-read-more', function (e) {
        e.preventDefault();
        let container = $(this).closest('.description-wrapper');
        let shortDesc = container.find('.short-desc');
        let fullDesc = container.find('.full-desc');

        if (fullDesc.is(':hidden')) {
            fullDesc.fadeIn(200);
            shortDesc.hide();
            $(this).text('Thu gọn');
        } else {
            fullDesc.hide();
            shortDesc.fadeIn(200);
            $(this).text('Xem thêm');
        }
    });

    // Cập nhật sản phẩm
    //Hiển thị ảnh preview trong modal
    $('.product-images').on('change', function (e) {
        let files = e.target.files;
        let productId = $(this).data('id');
        let previewContainer = $('#image-preview-container-' + productId);

        previewContainer.empty();

        if (files.length === 0) {
            previewContainer.append('<p>Không có ảnh nào được chọn</p>');
            return;
        }

        $.each(files, function (index, file) {
            let render = new FileReader();
            render.onload = function (e) {
                const img = $('<img>').attr('src', e.target.result)
                    .attr('alt', file.name)
                    .addClass('image-preview');
                previewContainer.append(img);
            }
            render.readAsDataURL(file);
        });
    });

    //update product
    $(document).on('click', '.btn-update-submit-product', function (e) {
        e.preventDefault();

        let button = $(this);
        let productId = button.data('id');
        let form = button.closest('.modal').find('form');
        let formData = new FormData(form[0]);

        formData.append('product_id', productId);

        form.find('.invalid-feedback').remove();
        form.find('.is-invalid').removeClass('is-invalid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            type: 'POST',
            url: '/admin/product/update',
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                button.prop('disabled', true);
                button.text('Đang cập nhật...');
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);

                    $(`#modalUpdate-${productId}`).modal('hide');

                    var table = $('#datatable-buttons').DataTable();
                    var row = $(`#product-row-${productId}`);

                    let fullDesc = res.data.description;
                    let words = fullDesc.split(/\s+/);
                    let shortDesc = words.length > 50 ? words.slice(0, 50).join(' ') + '...' : fullDesc;

                    let descHtml = `
                                    <div class="description-wrapper">
                                        <span class="short-desc">${shortDesc}</span>
                                        ${words.length > 50 ? `
                                            <span class="full-desc" style="display: none;">${fullDesc}</span>
                                            <br>
                                            <a href="javascript:void(0);" class="btn-read-more text-primary" style="font-size: 11px; font-weight: bold;">Xem thêm</a>
                                        ` : ''}
                                    </div>
                                `;

                    table.cell(row, 0).data(`<img src="${res.data.image_first}" class="image-product" width="80">`);
                    table.cell(row, 1).data(res.data.name);
                    table.cell(row, 2).data(`<strong>${res.data.category_name}</strong>`);
                    table.cell(row, 3).data(res.data.slug);
                    table.cell(row, 4).data(descHtml);
                    table.cell(row, 5).data(res.data.stock);
                    table.cell(row, 6).data(vnCurrency.format(res.data.price));

                    table.cell(row, 7).data(res.data.unit);
                    table.cell(row, 8).data(res.data.status === 'in_stock' ? 'Còn hàng' : 'Hết hàng');
                    table.row(row).invalidate().draw(false);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    toastr.error(Object.values(errors)[0][0]);
                } else if (xhr.status === 404) {
                    toastr.error(xhr.responseJSON?.message || 'Không tìm thấy sản phẩm');
                } else {
                    toastr.error('Đã có lỗi hệ thống xảy ra.');
                }
            },
            complete: function () {
                button.prop('disabled', false).text('Chỉnh sửa');
            }
        });
    });

    //delete product
    $(document).on('click', '.btn-delete-submit-product', function (e) {
        e.preventDefault();

        let button = $(this);
        let productId = button.data('id');
        let row = $(`#product-row-${productId}`);

        var table = $('#datatable-buttons').DataTable();

        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                type: 'POST',
                url: '/admin/product/delete',
                data: {
                    product_id: productId,
                },
                beforeSend: function () {
                    button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (res) {
                    if (res.status) {
                        toastr.success(res.message);
                        table.row(row).remove().draw(false);
                    } else {
                        toastr.error(res.message);
                        button.prop('disabled', false).html('<i class="fa fa-trash"></i> Xóa');
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                    if (xhr.status === 400) {
                        toastr.warning(xhr.responseJSON.message, 'Cảnh báo', {
                            timeOut: 5000
                        });
                    } else if (xhr.status === 404) {
                        toastr.error(xhr.responseJSON.message ?? "Sản phẩm không tồn tại");
                    } else {
                        toastr.error('Không thể thực hiện yêu cầu xóa lúc này.');
                    }
                    button.prop('disabled', false).html('<i class="fa fa-trash"></i> Xóa');
                },
                complete: function () {
                    button.prop('disabled', false).html('<i class="fa fa-trash"></i> Xóa');
                }
            });
        }
    });

    /****************************
     * COUPONS MANAGEMENT
    *****************************/

    //update coupon
    $(document).on('click', '.btn-update-submit-coupon', function (e) {
        e.preventDefault();

        let button = $(this);
        let couponId = button.data('id');
        let form = $(`#update-coupon-form-${couponId}`);

        let formData = new FormData(form[0]);

        formData.append('coupon_id', couponId);

        if (!formData.has('is_active')) {
            formData.append('is_active', '0');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            type: "POST",
            url: "/admin/coupon/update",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                button.prop('disabled', true).text('Đang lưu...');
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);
                    $(`#modalUpdate-${couponId}`).modal('hide');

                    var table = $('#datatable-buttons').DataTable();
                    var row = $(`#coupon-row-${couponId}`);

                    let typeText = res.data.type === 'percent' ? 'Phần trăm (%)' : 'Tiền mặt (đ)';
                    let valueText = res.data.type === 'percent' ? res.data.value + '%' : new Intl.NumberFormat('vi-VN').format(res.data.value) + 'đ';
                    let minOrder = vnCurrency.format(res.data.min_order_value) + 'đ';
                    let limit = res.data.usage_limit ? res.data.usage_limit : '∞';

                    let expiryDate = 'Không';
                    if (res.data.expires_at) {
                        let date = new Date(res.data.expires_at);
                        expiryDate = date.toLocaleDateString('vi-VN');
                    }

                    let statusHtml = res.data.is_active == 1
                        ? '<span class="badge badge-success">Kích hoạt</span>'
                        : '<span class="badge badge-secondary">Tạm dừng</span>';

                    table.cell(row, 0).data(`<strong class="text-primary">${res.data.code}</strong>`);
                    table.cell(row, 1).data(typeText);
                    table.cell(row, 2).data(valueText);
                    table.cell(row, 3).data(minOrder);
                    table.cell(row, 4).data(limit);
                    table.cell(row, 6).data(expiryDate);
                    table.cell(row, 7).data(statusHtml);

                    table.row(row).invalidate().draw(false);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    toastr.error(Object.values(errors)[0][0]);
                } else {
                    toastr.error('Đã có lỗi hệ thống xảy ra.');
                }
            },
            complete: function () {
                button.prop('disabled', false).text('Lưu thay đổi');
            }
        });
    });

    //delete coupon
    $(document).on('click', '.btn-delete-submit-coupon', function (e) {
        e.preventDefault();

        let button = $(this);
        let couponId = button.data('id');
        let row = $(`#coupon-row-${couponId}`);
        var table = $('#datatable-buttons').DataTable();

        if (confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                type: "POST",
                url: "/admin/coupon/delete",
                data: {
                    coupon_id: couponId,
                },
                beforeSend: function () {
                    button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (res) {
                    if (res.status) {
                        toastr.success(res.message);
                        table.row(row).remove().draw(false);
                    } else {
                        toastr.warning(res.message);
                        button.prop('disabled', false).html('<i class="fa fa-trash"></i> Xóa');
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                    if (xhr.status === 400) {
                        toastr.warning(xhr.responseJSON.message, 'Cảnh báo', {
                            timeOut: 5000
                        });
                    } else if (xhr.status === 404) {
                        toastr.error(xhr.responseJSON.message ?? "Mã khuyến mãi không tồn tại");
                    } else {
                        toastr.error('Không thể thực hiện yêu cầu xóa lúc này.');
                    }
                    button.prop('disabled', false).html('<i class="fa fa-trash"></i> Xóa');
                },
                complete: function () {
                    button.prop('disabled', false).html('<i class="fa fa-trash"></i> Xóa');
                }
            });
        }
    });


    /****************************
     * ORDERS MANAGEMENT
    *****************************/
    //Xác nhận đơn hàng
    $(document).on('click', '.confirm-order', function (e) {
        e.preventDefault();

        let button = $(this);
        let orderId = button.data('id');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            }
        });

        $.ajax({
            url: '/admin/order/confirm',
            type: 'POST',
            data: {
                order_id: orderId,
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);
                    button.closest('tr').find('.order-status').html(`
                            <span class="custom-badge badge badge-info">Đang xử lý</span>
                        `);
                    button.closest('.dropdown-menu').html(`
                            <a class="dropdown-item completed-order"
                                href="javascript:void(0)"
                                data-id="${orderId}">
                                Hoàn thành
                            </a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('admin.order-detail', ['id' => $order->id]) }}">Xem
                                chi
                                tiết</a>
                        `);
                    button.hide();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    toastr.error(Object.values(errors)[0][0]);
                } else if (xhr.status === 404) {
                    toastr.error(xhr.responseJSON.message ?? 'Đơn hàng không tồn tại');
                } else if (xhr.status === 400) {
                    toastr.error(xhr.responseJSON.message ?? 'Có lỗi nghiệp vụ xảy ra.');
                } else {
                    toastr.error('Không thể thực hiện xác nhận đơn hàng lúc này.');
                }
            },
        });
    });

    // hoàn thành đơn hàng
    $(document).on('click', '.completed-order', function (e) {
        e.preventDefault();

        let button = $(this);
        let orderId = button.data('id');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            }
        });

        $.ajax({
            url: '/admin/order/complete',
            type: 'POST',
            data: {
                order_id: orderId,
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);
                    button.closest('tr').find('.order-status').html(`
                            <span class="custom-badge badge badge-success">Đã hoàn thành</span>
                        `);
                    button.closest('tr').find('.order-payment-method').html(`
                        <span class="custom-badge badge badge-success">Đã thanh toán</span>
                        `);
                    button.hide();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    toastr.error(Object.values(errors)[0][0]);
                } else if (xhr.status === 404) {
                    toastr.error(xhr.responseJSON.message ?? 'Đơn hàng không tồn tại');
                } else if (xhr.status === 400) {
                    toastr.error(xhr.responseJSON.message ?? 'Có lỗi nghiệp vụ xảy ra.');
                } else {
                    toastr.error('Không thể thực hiện xác nhận hoàn thành đơn hàng lúc này.');
                }
            },
        });
    });

    //Gửi hóa đơn qua mail
    $(document).on('click', '.send-invoice-email', function (e) {
        e.preventDefault();

        let button = $(this);
        let orderId = button.data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            }
        });

        $.ajax({
            url: '/admin/order/send-invoice',
            type: 'POST',
            data: {
                order_id: orderId,
            },
            beforeSend: function () {
                button.prop('disabled', true);
                button.html('<i class="fa fa-spinner fa-spin"></i> Đang gửi...');
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);
                    button.remove();
                } else {
                    toastr.error(res.message);
                    button.prop('disabled', false);
                    button.html('<i class="fa fa-send"></i> Gửi hóa đơn');
                }
            },
            error: function (xhr) {
                console.error(xhr);
                console.log(xhr.responseJSON?.message);
                button.prop('disabled', false);
                button.html('<i class="fa fa-send"></i> Gửi hóa đơn');
            }
        });
    });

    //Hủy đơn hàng
    $(document).on('click', '.cancel-order', function (e) {
        e.preventDefault();

        let button = $(this);
        let orderId = button.data('id');

        if (!confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            }
        });

        $.ajax({
            type: 'POST',
            url: '/admin/order/canceled',
            data: {
                order_id: orderId,
            },
            beforeSend: function () {
                button.prop('disabled', true);
                button.html('<i class="fa fa-spinner fa-spin"></i> Đang hủy...');
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);

                    $('#order-status-badge').html(`
                            <span class="custom-badge badge badge-danger">
                                Đã hủy
                            </span>
                        `);
                    $('#payment-status-badge').html(`
                            <span class="custom-badge badge badge-danger">
                                Đã hủy
                            </span>
                        `);

                    button.prop('disabled', true);
                    button.removeClass('btn-danger')
                        .addClass('btn-secondary')
                        .html('<i class="fa fa-check"></i> Đã hủy');
                } else {
                    toastr.error(res.message);
                    button.prop('disabled', false);
                    button.html('<i class="fa fa-remove"></i> Hủy đơn hàng');
                }
            },
            error: function (xhr) {
                console.error(xhr);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    toastr.error(Object.values(errors)[0][0]);
                } else if (xhr.status === 404) {
                    toastr.error(xhr.responseJSON.message ?? 'Đơn hàng không tồn tại');
                } else if (xhr.status === 400) {
                    toastr.error(xhr.responseJSON.message ?? 'Có lỗi nghiệp vụ xảy ra.');
                } else {
                    toastr.error('Không thể thực hiện hủy đơn hàng lúc này.');
                }

                button.prop('disabled', false);
                button.html('<i class="fa fa-remove"></i> Hủy đơn hàng');
            },
        });
    });
});