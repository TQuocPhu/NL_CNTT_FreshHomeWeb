<!doctype html>
<html class="no-js" lang="zxx">


<!-- Mirrored from tunatheme.com/tf/html/broccoli-preview/broccoli/index-8.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 12 Feb 2025 04:54:29 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="{{ asset('assets/clients/img/favicon.png') }}" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/font-icons.css') }}">
    <!-- plugins css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/plugins.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/style.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/responsive.css') }}">

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/custom.css')}}">

    <!-- toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>

<body>
    <div class="wrapper">
        @include('clients.partials.header')

        @hasSection('breadcrumb')
            @include('clients.partials.breadcrumb')
        @endif

        <main>
            @yield('content')
        </main>

        @include('clients.partials.feature')
        @include('clients.partials.footer')
    </div>

    <!-- preloader area start -->
    <div class="preloader d-none" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
    <!-- preloader area end -->

    <!-- JQuery JS -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>


    {{--
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <!-- All JS Plugins -->
    <script src="{{ asset('assets/clients/js/plugins.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/clients/js/main.js') }}"></script>

    <!-- toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>

    @yield('scripts')
    <script src="{{asset('assets/clients/js/custom.js')}}"></script>

</body>

</html>