@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Quản lý người dùng</h3>
                </div>

                <div class="title_right">
                    <form method="GET" action="{{ route('admin.users.index') }}">
                        @csrf
                        <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                            <div class="input-group">
                                {{-- Thêm thuộc tính name="search" và giữ lại giá trị cũ --}}
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm theo Tên/Email/SĐT..." value="{{ request('search') }}">

                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Tìm!</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="clearfix"></div>
                        <div class="row row-user-card">
                            @foreach ($users as $user)
                                <div class="col-md-4 col-sm-4 profile_details" style="display: flex; margin-bottom: 20px;">
                                    <div class="well profile_view"
                                        style="display: flex; flex-direction: column; width: 100%; height: 100%; padding: 0; margin-bottom: 0; overflow: hidden;">

                                        <div class="profile-main-content" style="flex-grow: 1; padding: 15px;">
                                            <div class="col-sm-12" style="display: flex; align-items: flex-start;">

                                                <div class="left col-md-7 col-sm-7" style="padding-left: 0; flex: 1;">
                                                    <h4 class="brief text-uppercase" style="margin-top: 0;">
                                                        <i>{{ optional($user->role)->name }}</i>
                                                    </h4>
                                                    <h2 style="margin: 5px 0; font-size: 18px; font-weight: bold;">
                                                        {{ $user->name }}
                                                    </h2>
                                                    <p style="margin-bottom: 5px;"><strong>Email: </strong> {{ $user->email }}
                                                    </p>
                                                    <ul class="list-unstyled">
                                                        <li
                                                            style="{{ $user->address ? '' : 'font-style: italic; color: #999;' }}">
                                                            <i class="fa fa-building"></i> Địa chỉ:
                                                            {{ $user->address ?? "Chưa cập nhật!" }}
                                                        </li>
                                                        <li
                                                            style="{{ $user->phone_number ? '' : 'font-style: italic; color: #999;' }}">
                                                            <i class="fa fa-phone"></i> SĐT:
                                                            {{ $user->phone_number ?? "Chưa cập nhật!" }}
                                                        </li>

                                                        <li class="status-text">
                                                            <i
                                                                class="fa {{ $user->status == 'active' ? 'fa-check-circle text-success' : ($user->status == 'pending' ? 'fa-clock-o text-warning' : 'fa-times-circle text-danger') }}"></i>
                                                            Trạng thái:
                                                            <strong
                                                                style="color: {{ $user->status == 'active' ? '#26B99A' : ($user->status == 'pending' ? '#f0ad4e' : '#d9534f') }}">
                                                                {{ $user->status == 'active' ? 'Đã kích hoạt' : ($user->status == 'pending' ? 'Chờ duyệt' : ucfirst($user->status)) }}
                                                            </strong>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="right col-md-5 col-sm-5 text-center"
                                                    style="padding: 0; display: flex; justify-content: center; align-items: center;">
                                                    <div style="width: 100%; padding: 5px;">
                                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                                            class="img-circle img-fluid" style="width: 100% !important; 
                                                                                                aspect-ratio: 1 / 1; 
                                                                                                object-fit: cover; 
                                                                                                border: 1px solid #ddd; 
                                                                                                display: block;">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="profile-bottom text-center"
                                            style="margin-top: auto; background: #f5f5f5; padding: 10px; width: 100%; border-top: 1px solid #e5e5e5;">
                                            <div class="col-sm-4 role-user-button">
                                                @if ($user->role->name == 'admin')
                                                    <button type="button" class="btn btn-primary btn-xs" disabled
                                                        style="opacity: 1; cursor: default; font-weight: bold; text-transform: uppercase; min-width: 80px;">
                                                        <i class="fa fa-shield"></i> Quản trị viên
                                                    </button>
                                                @elseif ($user->role->name == 'staff')
                                                    <button type="button" class="btn btn-success btn-xs" disabled
                                                        style="opacity: 1; cursor: default; font-weight: bold; text-transform: uppercase; min-width: 80px;">
                                                        <i class="fa fa-user-md"></i> Nhân viên
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-xs" disabled
                                                        style="opacity: 1; cursor: default; font-weight: bold; text-transform: uppercase; min-width: 80px; background-color: #6c757d; border-color: #6c757d; color: #fff;">
                                                        <i class="fa fa-user"></i> Khách hàng
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="col-sm-8 emphasis"
                                                style="display: flex; justify-content: center; gap: 5px;">
                                                @if ($user->role->name == 'customer')

                                                    @if ($user->status == 'pending')
                                                        <button type="button" class="btn btn-success btn-sm changeStatus"
                                                            data-userid="{{ $user->id }}" data-status="active">
                                                            <i class="fa fa-check"></i> Kích hoạt
                                                        </button>
                                                    @endif

                                                    @if($user->status == 'active')
                                                        <button type="button" class="btn btn-primary btn-sm upgradeStaff"
                                                            data-userid="{{ $user->id }}">
                                                            <i class="fa fa-user"> </i> Nhân viên
                                                        </button>
                                                    @endif

                                                    @if ($user->status == 'banned')
                                                        <button type="button" class="btn btn-success btn-sm changeStatus"
                                                            data-userid="{{ $user->id }}" data-status="active">
                                                            <i class="fa fa-unlock-alt"> </i> Mở khóa
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-warning btn-sm changeStatus"
                                                            data-userid="{{ $user->id }}" data-status="banned">
                                                            <i class="fa fa-lock"> </i> Khóa
                                                        </button>
                                                    @endif

                                                    @if ($user->status == 'deleted')
                                                        <button type="button" class="btn btn-success btn-sm changeStatus"
                                                            data-userid="{{ $user->id }}" data-status="active">
                                                            <i class="fa fa-unlock-alt"> </i> Khôi phục
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-danger btn-sm changeStatus"
                                                            data-userid="{{ $user->id }}" data-status="deleted">
                                                            <i class="fa fa-remove"> </i> Xóa
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                {{ $users->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection