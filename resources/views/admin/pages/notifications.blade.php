@extends('layouts.admin')

@section('title', 'Quản Lý Thông Báo')

@section('content')

    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Thông báo chưa đọc</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Tại đây. admin có thể xem và quản lý các thông báo chưa đọc từ khách hàng, trả lời câu hỏi
                                <br>
                                và theo dõi các ý kiến để cải thiện dịch vụ.
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-9 col-sm-9 ">
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active " aria-labelledby="home-tab">
                                                <ul class="messages">
                                                    @forelse ($notifications as $notification)
                                                        <li style="display:flex; align-items: center;">
                                                            <i class="fa fa-bell"></i>

                                                            <div class="message_wrapper" style="min-width: 600px;">
                                                                <a href="{{ '../admin' . $notification->link }}"
                                                                    class="notification-item" data-id="{{ $notification->id }}">
                                                                    <h4 class="heading">{{ $notification->title }}</h4>
                                                                </a>
                                                                <blockquote class="message">
                                                                    {{ Str::limit($notification->message, 50) }}</blockquote>
                                                                <br />
                                                            </div>
                                                            <div class="message_date">
                                                                <p class="month">
                                                                    {{ $notification->created_at->format('h:i A d-m-Y') }}</p>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <p class="text-gray">Không có thông báo mới</p>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection