@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="right_col" role="main">
        <div class="row" style="display: inline-block; width: 100%;">
            <div class="tile_count">

                <div class="col-md-2 col-sm-4 tile_stats_count">
                    <span class="count_top"><i class="fa fa-money"></i> Tổng doanh thu (VND)</span>
                    <div class="count">{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <span class="count_bottom"><i class="red"><i class="fa fa-close"></i> {{ $totalFailedPayments }}</i> Lỗi
                        thanh toán</span>
                </div>

                <div class="col-md-2 col-sm-4 tile_stats_count">
                    <span class="count_top"><i class="fa fa-shopping-cart"></i> Tổng đơn hàng</span>
                    <div class="count green">{{ $totalOrders }}</div>
                    <span class="count_bottom"><i class="red"><i class="fa fa-trash-o"></i> {{ $totalCanceledOrders }}</i>
                        Đơn đã hủy</span>
                </div>

                <div class="col-md-2 col-sm-4 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Tổng khách hàng</span>
                    <div class="count">{{ $totalUsers }}</div>
                    <span class="count_bottom">Vai trò: Khách hàng</span>
                </div>

                <div class="col-md-2 col-sm-4 tile_stats_count">
                    <span class="count_top"><i class="fa fa-cubes"></i> Tổng sản phẩm</span>
                    <div class="count">{{ $totalProducts }}</div>
                    <span class="count_bottom">Trong kho hệ thống</span>
                </div>

                <div class="col-md-2 col-sm-4 tile_stats_count">
                    <span class="count_top"><i class="fa fa-list"></i> Danh mục SP</span>
                    <div class="count">{{ $totalCategories }}</div>
                    <span class="count_bottom">Ngành hàng hiện có</span>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="dashboard_graph">

                    <div class="row x_title">
                        <div class="col-md-6">
                            <h3>Network Activities <small>Graph title sub-title</small></h3>
                        </div>
                        <div class="col-md-6">
                            <div id="reportrange" class="pull-right"
                                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-9 ">
                        <div id="chart_plot_01" class="demo-placeholder"></div>
                    </div>
                    <div class="col-md-3 col-sm-3  bg-white">
                        <div class="x_title">
                            <h2>Top Campaign Performance</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-12 col-sm-12 ">
                            <div>
                                <p>Facebook Campaign</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p>Twitter Campaign</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 ">
                            <div>
                                <p>Conventional Media</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p>Bill boards</p>
                                <div class="">
                                    <div class="progress progress_sm" style="width: 76%;">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
        <br />

        <div class="row">


            <div class="col-md-4 col-sm-4 ">
                <div class="x_panel tile fixed_height_320">
                    <div class="x_title">
                        <h2>App Versions</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h4>App Usage across versions</h4>
                        <div class="widget_summary">
                            <div class="w_left w_25">
                                <span>0.1.5.2</span>
                            </div>
                            <div class="w_center w_55">
                                <div class="progress">
                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 66%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w_right w_20">
                                <span>123k</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="widget_summary">
                            <div class="w_left w_25">
                                <span>0.1.5.3</span>
                            </div>
                            <div class="w_center w_55">
                                <div class="progress">
                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w_right w_20">
                                <span>53k</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="widget_summary">
                            <div class="w_left w_25">
                                <span>0.1.5.4</span>
                            </div>
                            <div class="w_center w_55">
                                <div class="progress">
                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w_right w_20">
                                <span>23k</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="widget_summary">
                            <div class="w_left w_25">
                                <span>0.1.5.5</span>
                            </div>
                            <div class="w_center w_55">
                                <div class="progress">
                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 5%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w_right w_20">
                                <span>3k</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="widget_summary">
                            <div class="w_left w_25">
                                <span>0.1.5.6</span>
                            </div>
                            <div class="w_center w_55">
                                <div class="progress">
                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w_right w_20">
                                <span>1k</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 ">
                <div class="x_panel tile fixed_height_320 overflow_hidden">
                    <div class="x_title">
                        <h2>Device Usage</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="" style="width:100%">
                            <tr>
                                <th style="width:37%;">
                                    <p>Top 5</p>
                                </th>
                                <th>
                                    <div class="col-lg-7 col-md-7 col-sm-7 ">
                                        <p class="">Device</p>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 ">
                                        <p class="">Progress</p>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <canvas class="canvasDoughnut" height="140" width="140"
                                        style="margin: 15px 10px 10px 0"></canvas>
                                </td>
                                <td>
                                    <table class="tile_info">
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-square blue"></i>IOS </p>
                                            </td>
                                            <td>30%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-square green"></i>Android </p>
                                            </td>
                                            <td>10%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-square purple"></i>Blackberry </p>
                                            </td>
                                            <td>20%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-square aero"></i>Symbian </p>
                                            </td>
                                            <td>15%</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-square red"></i>Others </p>
                                            </td>
                                            <td>30%</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-4 col-sm-4 ">
                <div class="x_panel tile fixed_height_320">
                    <div class="x_title">
                        <h2>Quick Settings</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="dashboard-widget-content">
                            <ul class="quick-list">
                                <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
                                </li>
                                <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
                                </li>
                                <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                                <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                                </li>
                                <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                                <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                                </li>
                                <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
                                </li>
                            </ul>

                            <div class="sidebar-widget">
                                <h4>Profile Completion</h4>
                                <canvas width="150" height="80" id="chart_gauge_01" class=""
                                    style="width: 160px; height: 100px;"></canvas>
                                <div class="goal-wrapper">
                                    <span id="gauge-text" class="gauge-value pull-left">0</span>
                                    <span class="gauge-value pull-left">%</span>
                                    <span id="goal-text" class="goal-value pull-right">100%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row d-flex align-items-stretch equal-height">
            <div class="col-md-6 col-sm-6 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Người dùng mới <small>Danh sách</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Khách hàng</th>
                                    <th>Số điện thoại</th>
                                    {{-- <th>Địa chỉ</th> --}}
                                    <th>Email</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($newUsers as $index => $user)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $user->name ?? '*Trống' }}</td>
                                        <td>{{ $user->phone_number ?? '*Trống' }}</td>
                                        {{-- <td>
                                            <div class="truncate-text">{{ $user->address ?? '*Trống' }}</div>
                                        </td> --}}
                                        <td>{{ $user->email ?? '*Trống' }}</td>
                                        <td>
                                          @switch($user->status)
                                              @case('active')
                                                  <span class="custom-badge badge badge-success">Đã kích hoạt</span>
                                                  @break
                                              @case('pending')
                                              <span class="custom-badge badge badge-warning">Chưa kích hoạt</span>
                                                  @break
                                              @case('banned')
                                              <span class="custom-badge badge badge-secondary">Đã khóa</span>
                                                  @break
                                              @case('deleted')
                                              <span class="custom-badge badge badge-danger">Đã xóa</span>
                                                  @break
                                              @default
                                                  Không có
                                          @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Chưa có dữ liệu khách hàng</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Đơn hàng nổi bật <small>Danh sách</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã số</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền hàng</th>
                                    <th>Tổng thanh toán</th>
                                    <th>Khách hàng</th>
                                    <th>Địa chỉ giao hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ratingOrders as $index => $order)
                                    <tr>
                                        <td>{{ $order->id ?? '*Trống' }}</td>
                                        <td>{{ $order->created_at->format('H:i d/m/Y') ?? '*Trống' }}</td>
                                        <td>{{ number_format($order->total_price ?? 0, 0, ',', '.') }} đ</td>
                                        <td>{{ number_format($order->payment->amount ?? 0, 0, ',', '.') }} đ</td>
                                        <td>
                                            {{ $order->user->name ?? '*Trống' }}
                                        </td>
                                        <td>
                                            <div class="truncate-text">
                                                {{ $order->shippingAddress->address ?? '*Trống' }}, {{ $order->shippingAddress->city ?? '*Trống' }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Chưa có dữ liệu bán hàng</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex align-items-stretch equal-height">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Sản phẩm bán chạy <small>Danh sách</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá (đ)</th>
                                    <th>Số lượng đã bán</th>
                                    <th>Doanh thu(đ)</th>
                                    <th>Kho</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topSellingProducts as $index => $product)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                    
                                        <td>
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="50" height="50">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-primary px-3">{{ $product->total_sold }}</span>
                                        </td>
                                        <td class="fw-bold text-success">
                                            {{ number_format($product->actual_revenue, 0, ',', '.') }} đ
                                        </td>
                                        <td>
                                            @if($product->stock > 10)
                                                <span class="text-success small"><i class="fas fa-check-circle-o"></i> Sẵn hàng</span>
                                            @elseif($product->stock > 0)
                                                <span class="text-warning small"><i class="fas fa-exclamation-triangle"></i> Sắp hết ({{ $product->stock }})</span>
                                            @else
                                                <span class="text-danger small"><i class="fas fa-times-circle"></i> Hết hàng</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Chưa có dữ liệu sản phẩm</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection