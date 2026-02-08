$(document).ready(function () {

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
    })
});