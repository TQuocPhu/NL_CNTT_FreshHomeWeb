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
});