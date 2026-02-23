<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>FRESH HOME!</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Xin chào,</span>
                <h2>John Doe</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Tổng quan</h3>
                @php
                    $adminUser = Auth::guard('admin')->user();
                @endphp
                <ul class="nav side-menu">

                    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard </a></li>

                    @if ($adminUser->role->permissions->contains('name', 'manage_users'))
                        <li><a href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i> Quản lý người dùng </a>
                        </li>
                    @endif

                    @if ($adminUser->role->permissions->contains('name', 'manage_categories'))
                        <li><a><i class="fa fa-sitemap"></i> Quản lý danh mục <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('admin.categories.add') }}"> Thêm danh mục </a></li>
                                <li><a href="{{ route('admin.categories.index') }}"> Danh sách danh mục </a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($adminUser->role->permissions->contains('name', 'manage_products'))
                        <li><a><i class="fa fa-cubes"></i> Quản lý sản phẩm <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('admin.products.add') }}"> Thêm sản phẩm </a></li>
                                <li><a href="{{ route('admin.products.index') }}"> Danh sách sản phẩm </a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($adminUser->role->permissions->contains('name', 'manage_coupons'))
                        <li><a><i class="fa fa-tags"></i> Quản lý mã khuyến mãi <span
                                    class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('admin.coupons.add') }}"> Thêm mã khuyến mãi </a></li>
                                <li><a href="{{ route('admin.coupons.index') }}"> Danh sách mã khuyến mãi </a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($adminUser->role->permissions->contains('name', 'manage_orders'))
                        <li>
                            <a href="#"><i class="fa fa-shopping-cart"></i> Quản lý đơn hàng </a>
                        </li>
                    @endif

                    @if ($adminUser->role->permissions->contains('name', 'manage_contacts'))
                        <li>
                            <a href="#"><i class="fa fa-paper-plane"></i> Quản Lý Liên hệ </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Đăng xuất" href="{{ route('admin.logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</div>
