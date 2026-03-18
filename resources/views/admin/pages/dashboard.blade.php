@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="right_col" role="main">
        <div class="row" style="display: inline-block; width: 100%;">
            <div class="tile_count">

                <div class="col-md-2 col-sm-4 tile_stats_count">
                    <span class="count_top"><i class="fa fa-money"></i> Tổng doanh thu (VND)</span>
                    <div class="count">{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    {{-- <span class="count_bottom"><i class="red"><i class="fa fa-close"></i> {{ $totalFailedPayments }}</i> Lỗi
                        thanh toán</span> --}}
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

        <div class="row d-flex align-items-stretch">
            <div class="col-md-8 col-sm-8">
                <div class="x_panel h-100">
                    <div class="x_title d-flex justify-content-between align-items-center">
                        <h2>Báo cáo thống kê</h2>

                        {{-- Select năm --}}
                        <form method="GET" action="{{ route('admin.dashboard') }}">
                            <select name="year" onchange="this.form.submit()" class="form-control">
                                @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        Năm {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </form>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                <div class="x_content">

                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="chartTabs">
                    <li class="active">
                        <a data-toggle="tab" href="#lineTab">Doanh thu</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#barTab">Đơn hàng</a>
                    </li>
                </ul>

                <div class="tab-content" style="margin-top:15px">

                    {{-- Line chart --}}
                    <div id="lineTab" class="tab-pane fade show active">
                        <canvas 
                            id="revenueLineChart"
                            data-revenues='@json($revenues)'
                            data-year="{{ $year }}"
                            height="100">
                        </canvas>
                    </div>

                    {{-- Bar chart --}}
                    <div id="barTab" class="tab-pane fade">
                        <canvas
                            id="orderBarChart"
                            data-success='@json($orderSuccess)'
                            data-canceled='@json($orderCanceled)'
                            data-year="{{ $year }}"
                            height="100">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


            {{-- ===== RIGHT 35% ===== --}}
            <div class="col-md-4 col-sm-4 ">
                <div class="x_panel tile h-100 overflow_hidden">
                    <div class="x_title">
                        <h2>Danh mục sản phẩm</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content d-flex ">
                        <div class="row w-100">
                        @php
                            $count = count($chartLabels);
                            $colors = [];

                            for ($i = 0; $i < $count; $i++) {
                                $hue = intval((360 / $count) * $i);
                                $colors[] = "hsl($hue, 70%, 60%)";
                            }
                        @endphp
                            {{-- 35% Donut --}}
                            <div class="col-md-12 text-center">
                                <canvas id="categoryDonutChart" 
                                    data-labels='@json($chartLabels)' 
                                    data-data='@json($chartData)' 
                                    data-colors='@json($colors)' 
                                    height="120">
                                </canvas>
                            </div>
                        
                            {{-- 65% Thống kê --}}
                            <div class="col-md-12">
                            
                                <div class="d-flex justify-content-between fw-bold mb-2">
                                    <span>Danh mục</span>
                                    <span>Số sản phẩm</span>
                                </div>
                            <div class="category-scroll-area" style="max-height: 200px; overflow-y: auto; overflow-x: hidden; padding-right: 5px;">
                                @foreach ($chartLabels as $index => $label)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <i class="fa fa-square me-2"
                                               style="color: {{ $colors[$index] }}"></i>
                                            {{ $label }}
                                        </div>
                                        <div class="fw-bold">
                                            {{ $chartData[$index] }} SP
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>

        </div>
        <br />

        <div class="row d-flex align-items-stretch equal-height">
            <div class="col-md-6 col-sm-6 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Người dùng mới <small>Danh sách</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
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