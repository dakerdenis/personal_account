<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow"/>
    <title>A-group Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/style.css">
    <link id="color" rel="stylesheet" href="{{ asset('backend/assets') }}/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets') }}/css/responsive.css">
</head>
<body>
<!-- login page start-->
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="javascript:void(0);"><img class="img-fluid for-light"
                                                                         src="{{ asset('backend/assets/images/company_logo.svg') }}"
                                                                         width="200" alt="looginpage"><img
                                class="img-fluid for-dark" src="{{ asset('backend/assets/images/company_logo.svg') }}"
                                alt="looginpage"></a>
                    </div>
                    <div class="login-main">
                        <form action="{{ route('backend.login') }}" method="post" class="theme-form needs-validation"
                              novalidate>
                            <h4>Sign in to account</h4>
                            <p>Enter your email & password to login</p>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email Address</label>
                                <input id="email" class="form-control" type="email" required="" placeholder=""
                                       name="email">
                                @error('email')
                                <div style="display: block; color: red" class="invalid-feedback ">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password</label>
                                <input id="password" class="form-control" type="password" name="password" required=""
                                       placeholder="*********">
                                @error('password')
                                <div style="display: block; color: red" class="invalid-feedback ">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input name="remember" id="checkbox1" type="checkbox">
                                    <label class="text-muted" for="checkbox1">Remember password</label>
                                </div>
                                <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

    </script>
    <!-- latest jquery-->
    <script src="{{ asset('backend/assets') }}/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('backend/assets') }}/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="{{ asset('backend/assets') }}/js/icons/feather-icon/feather.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="{{ asset('backend/assets') }}/js/config.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('backend/assets') }}/js/script.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
</div>
</body>
</html>

