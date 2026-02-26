<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ $userAdmin->avatar_url }}" alt="{{ $userAdmin->name }}">{{ $userAdmin->name }}
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.profile') }}"> Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                class="fa fa-sign-out pull-right"></i>
                            Đăng xuất</a>
                    </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">{{ $messages->count() }}</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                        @if ($messages->count() === 0)
                            <li class="nav-item">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <span>
                                        <span>Không có liên hệ mới</span>
                                    </span>
                                </a>
                            </li>

                        @endif
                        @for ($i = 0; $i < min(3, $messages->count()); $i++)
                            <li class="nav-item">
                                <a class="dropdown-item">
                                    <span class="image"><img src="{{ asset('assets/admin/images/favicon.png') }}"
                                            alt="Profile Image" /></span>
                                    <span>
                                        <span>{{ $messages[$i]->full_name }}</span>
                                        <span
                                            class="time">{{ $messages[$i]->created_at->setTimezone('Asia/Ho_Chi_Minh')->diffForHumans() }}</span>
                                    </span>
                                    <span class="message custom-message-top">
                                        {{ Str::limit($messages[$i]->message, 30) }}
                                    </span>
                                </a>
                            </li>
                        @endfor
                        <li class="nav-item">
                            <div class="text-center">
                                <a class="dropdown-item" href="{{ route('admin.contacts.index') }}">
                                    <strong>Xem tất cả liên hệ</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown open" style="margin-right: 12px">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge bg-green notification-badge">{{ $notifications->count() }}</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list">
                        @if ($notifications->count() === 0)
                            <li class="nav-item">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <span>
                                        <span>Không có thông báo mới</span>
                                    </span>
                                </a>
                            </li>

                        @endif
                        @for ($i = 0; $i < min(3, $notifications->count()); $i++)
                            <li class="nav-item">
                                <a class="dropdown-item">
                                    <span><i class="fa fa-bell-o"></i></span>
                                    <span>
                                        <span>{{ $notifications[$i]->title }}</span>
                                        <span
                                            class="time">{{ $notifications[$i]->created_at->setTimezone('Asia/Ho_Chi_Minh')->diffForHumans() }}
                                        </span>
                                    </span>
                                    <span class="message custom-message-top-nav">
                                        {{ $notifications[$i]->message }}
                                    </span>
                                </a>
                            </li>
                        @endfor
                        <li class="nav-item">
                            <div class="text-center">
                                <a href="{{ route('admin.notification.index') }}" class="dropdown-item">
                                    <strong>Xem tất cả thông báo </strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>