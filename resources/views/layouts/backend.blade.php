<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>A-group admin</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{asset('backend/assets/fonts/fontawesome-free-6.0.0-web/css/all.min.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/themify.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/animate.css">
    @yield('styles')
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/style.css">
    <link id="color" rel="stylesheet" href="{{ asset('backend/assets') }}/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/responsive.css">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

</head>
<body class="dark-sidebar {{session('mode') == 'dark' ? 'dark-only' : ''}}">
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    @include('backend.partials.header')
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        @include('backend.partials.sidebar')
        <!-- Page Sidebar Ends-->
            <div class="page-body">
                @yield('content')
            </div>
        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Created by <a href="https://mediadesign.az" target="_blank">MediaDesign</a> </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<div id="loader-overlay" class="position-fixed w-100 h-100 justify-content-center align-items-center" style="top: 0;left: 0;background: rgba(0,0,0,.5); z-index: 4515152; display: none">
    <div class="loader-box">
        <div class="loader-39"></div>
    </div>
</div>
<!-- latest jquery-->
<script src="{{ asset('backend/assets') }}/js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap js-->
<script src="{{ asset('backend/assets') }}/js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- feather icon js-->
<script src="{{ asset('backend/assets') }}/js/icons/feather-icon/feather.min.js"></script>
<script src="{{ asset('backend/assets') }}/js/icons/feather-icon/feather-icon.js"></script>
<!-- scrollbar js-->
<script src="{{ asset('backend/assets') }}/js/scrollbar/simplebar.js"></script>
<script src="{{ asset('backend/assets') }}/js/scrollbar/custom.js"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('backend/assets') }}/js/config.js"></script>
<!-- Plugins JS start-->
<script src="{{ asset('backend/assets') }}/js/sidebar-menu.js"></script>

@yield('scripts')
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('backend/assets') }}/js/script.js"></script>
<!-- login js-->
<!-- Plugin used-->
</body>
</html>

