@extends('layouts.client')

@section('title', 'Tài khoản')
@section('breadcrumb', 'Tài khoản')

@section('content')

    <div class="liton__wishlist-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- PRODUCT TAB AREA START -->
                    <div class="ltn__product-tab-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="ltn__tab-menu-list mb-50">
                                        <div class="nav">
                                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_dashboard">Bảng
                                                điều khiển <i class="fas fa-home"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_address">Địa chỉ <i
                                                    class="fas fa-map-marker-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_order">Đơn hàng <i
                                                    class="fas fa-file-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_account">Thông tin tài khoản <i
                                                    class="fas fa-arrow-down"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_password">Đổi mật khẩu <i
                                                    class="fas fa-user"></i></a>
                                            <a href="{{ route('logout') }}">Đăng xuất <i
                                                    class="fas fa-sign-out-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="liton_tab_dashboard">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Xin chào <strong>{{ $user->email }}</strong> (không phải
                                                    <strong>{{ $user->email }}</strong>?
                                                    <small><a href="{{ route('logout') }}">Đăng xuất</a></small> )
                                                </p>
                                                <p>Từ bảng điều khiển tài khoản của bạn, bạn có thể xem <span>đơn hàng gần
                                                        đây</span>,
                                                    quản lý <span>địa chỉ giao hàng và thanh toán</span>,
                                                    cũng như <span>chỉnh sửa mật khẩu và thông tin tài khoản</span>.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_address">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Các địa chỉ sau sẽ được sử dụng mặc định trên trang thanh toán.</p>
                                                <div class="table-responsive" style="overflow-x: auto; overflow-y: scroll; max-height: 400px;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Tên người nhận</th>
                                                                <th>Địa chỉ</th>
                                                                <th>Thành phố</th>
                                                                <th>Số điện thoại</th>
                                                                <th>Mặc định</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($addresses as $address)
                                                                <tr>
                                                                    <td>{{ $address->full_name }}</td>
                                                                    <td>{{ $address->address }}</td>
                                                                    <td>{{ $address->city }}</td>
                                                                    <td>{{ $address->phone }}</td>
                                                                    <td>
                                                                        Chọn
                                                                    </td>
                                                                    <td>
                                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                            onclick="return confirm('Bạn có chắc chắn xóa địa chỉ này?')">
                                                                            Xóa
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn theme-btn-1 btn-effect-1 text-uppercase mt-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">Thêm địa
                                                    chỉ mới</button>
                                            </div>
                                        </div>


                                        <!-- Modal -->
                                        <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="padding: 10px;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('account.addresses.add') }}" method="post" id="addAddressForm">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="full_name" class="form-label">Tên người nhận</label>
                                                                <input type="text" class="form-control" name="full_name" id="full_name" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="phone" class="form-label">Số điện thoại</label>
                                                                <input type="text" class="form-control" name="phone" id="phone" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="address" class="form-label">Địa chỉ</label>
                                                                <input type="text" class="form-control" name="address" id="address" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="city" class="form-label">Thành phố</label>
                                                                <input type="text" class="form-control" name="city" id="city" required>
                                                            </div>

                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox" class="form-check-input" name="default" id="default">
                                                                <label for="default" class="form-label">Đặt là địa chỉ mặc định</label>
                                                            </div>
                                                            <button type="submit" class="btn theme-btn-1 btn-effect-1 text-uppercase mt-3">Lưu địa chỉ</button>
                                                        </form>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="liton_tab_order">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Đơn hàng</th>
                                                                <th>Thời điểm đặt</th>
                                                                <th>Tổng tiền hàng</th>
                                                                <th>Tổng tiền trả</th>
                                                                <th>Trạng thái đơn hàng</th>
                                                                <th>Thanh toán</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Carsafe - Car Service PSD Template</td>
                                                                <td>Nov 22, 2020</td>
                                                                <td>Yes</td>
                                                                <td>Yes</td>
                                                                <td>Yes</td>
                                                                <td>Yes</td>
                                                                <td><a href="cart.html">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_account">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="ltn__form-box">
                                                    <form action="{{ route('account.profile') }}" method="post" id="update-account"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="row mb-50">

                                                            <div class="col-md-12 text-center mb-3">
                                                                <div class="profile-pic-container">
                                                                    <img src="{{ $user->avatar_url }}" alt="Avatar"
                                                                        id="preview-image" class="profile-pic" referrerpolicy="no-referrer">

                                                                    <input type="file" name="avatar" id="avatar"
                                                                        accept="image/*" class="d-none" {{ $user->google_id ? 'disabled' : '' }}>

                                                                    @if($user->google_id)
                                                                        <p class="text-danger mt-2"><small>* Ảnh được đồng bộ từ
                                                                                Google</small></p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 form-group">
                                                                <label>Họ và tên:</label>
                                                                <input type="text" name="ltn__name" id="ltn__name"
                                                                    value="{{ $user->name }}" required
                                                                    {{ $user->google_id ? 'readonly' : '' }}>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Số điện thoại:</label>
                                                                <input type="number" name="ltn__phone_number"
                                                                    id="ltn__phone_number" value="{{ $user->phone_number }}"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label for="ltn__email">Email <span
                                                                        style="font-style: italic">(không được thay
                                                                        đổi*)</span></label>
                                                                <input type="text" name="ltn__email" id="ltn__email"
                                                                    value="{{ $user->email }}" readonly>
                                                            </div>

                                                            <div class="col-md-6 form-group">
                                                                <label for="ltn__address">Địa chỉ</label>
                                                                <input type="text" name="ltn__address" id="ltn__address"
                                                                    value="{{ $user->address }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                class="btn theme-btn-1 btn-effect-1 text-uppercase">Cập
                                                                nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_password">
                                            <div class="ltn__myaccount-tab-content-inner">

                                                <div class="ltn__form-box">
                                                    <form action="{{ route('account.change-password') }}" method="post" id="change-password-form">
                                                        @csrf
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    @if($user->google_id)
                                                                        <p class="text-danger text-center font-weight-bold">
                                                                            <i class="fas fa-info-circle"></i> 
                                                                            Tài khoản Google không cần đổi mật khẩu.
                                                                        </p>
                                                                    @endif
                                                                    <label>Mật khẩu hiện tại :</label>
                                                                    <input type="password" name="current_password" {{ $user->google_id ? 'disabled' : 'required' }}>
                                                                    <label>Mật khẩu mới:</label>
                                                                    <input type="password" name="new_password" {{ $user->google_id ? 'disabled' : 'required' }}>
                                                                    <label>Nhập lại mật khẩu mới:</label>
                                                                    <input type="password" name="new_password_confirmation"
                                                                        autocomplete="new-password" {{ $user->google_id ? 'disabled' : 'required' }}>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                class="btn theme-btn-1 btn-effect-1 text-uppercase" {{ $user->google_id ? 'disabled' : '' }}>Đổi mật
                                                                khẩu</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PRODUCT TAB AREA END -->
                </div>
            </div>
        </div>
    </div>

@endsection