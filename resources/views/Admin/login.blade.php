<!DOCTYPE html>

<html lang="en">

<?php

$value = env('APP_URL', 'default_value');

?>

<meta name="csrf-token" content="{{ csrf_token() }}" />

<?php

$url = URL::to('/dashboard');

?>

<!--begin::Head-->
<head>

    @php
        $url = Request::route()->getName();
        $currentRouteName = Route::currentRouteName();

        $prefix = strtoupper(explode('.', $currentRouteName)[0]);

    @endphp

<link rel="icon" href="{{ static_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ static_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
<title>{{ config('app.name') }} - {{ $prefix }}</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
    rel="stylesheet">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css"
        href="{{ static_asset('admin/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css_bk/style.css') }}">
    <link id="color" rel="stylesheet"
        href="{{ static_asset('admin/assets/css/color-1.css" media="screen') }}">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/responsive.css') }}">

</head>

<!--end::Head-->



<body>

    <!-- login page start-->

    <div class="container-fluid">

        <div class="row">

            <div class="col-xl-6"><img class="bg-img-cover bg-center"
                    src="{{ static_asset('admin/assets/images/login/login.jpg') }}" alt="looginpage"></div>

            <div class="col-xl-6 p-0">

                <div class="login-card login-dark">

                    <div>

                        <div><a class="logo text-start text-center" href="javascript:void(0)"><img
                                    class="img-fluid for-light text-align-center"
                                    src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt="looginpage"></a>
                        </div>

                        <div class="login-main">



                            <form method="POST" action="{{ route('admin-login') }}" class="theme-form">

                                @csrf

                                <h4>{{ __('labels.login') }}</h4>

                                <p>{{ __('labels.Enter your email & password to login') }}</p>



                                <div class="form-group">

                                    <label class="col-form-label">{{ __('labels.Email') }}</label>

                                    <div class="form-input position-relative">

                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            name="email" placeholder="{{ __('labels.Email') }}"
                                            value="{{ old('email') }}">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>
                                        @enderror

                                    </div>



                                </div>



                                <div class="form-group">

                                    <label class="col-form-label">{{ __('labels.Password') }}</label>

                                    <div class="form-input position-relative">

                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" name="password" placeholder="{{ __('labels.Password') }}"
                                            value="{{ old('password') }}">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>
                                        @enderror

                                    </div>



                                </div>

                                <div class="form-group mb-0">

                                    <div class="text-end mt-3">

                                        <input class="btn btn-primary btn-block w-100" type="submit"
                                            value="{{ __('labels.Login') }}">

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- latest jquery-->

        <script src="{{ static_asset('admin/assets/js/jquery.min.js') }}"></script>

        <!-- Bootstrap js-->

        <script src="{{ static_asset('admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

        <!-- feather icon js-->

        <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather.min.js') }}"></script>

        <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather-icon.js') }}"></script>

        <!-- scrollbar js-->

        <script src="{{ static_asset('admin/assets/js/scrollbar/simplebar.js') }}"></script>

        <script src="{{ static_asset('admin/assets/js/scrollbar/custom.js') }}"></script>

        <!-- Sidebar jquery-->

        <script src="{{ static_asset('admin/assets/js/config.js') }}"></script>

        <script src="{{ static_asset('admin/assets/js/notify/bootstrap-notify.min.js') }}"></script>



        <!-- Plugins JS Ends-->

        <!-- Theme js-->

        <script src="{{ static_asset('admin/assets/js/script.js') }}"></script>



        <script>
            new WOW().init();
        </script>





        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



        <script>
            toastr.options = {

                "closeButton": true,

                "progressBar": true

            }

            @if (Session::has('success'))

                toastr.success("{{ session('success') }}");
            @endif

            @if (Session::has('error'))

                toastr.error("{{ session('error') }}");
            @endif

            @if (Session::has('message'))

                toastr.success("{{ session('message') }}");
            @endif



            @if (Session::has('info'))

                toastr.info("{{ session('info') }}");
            @endif



            @if (Session::has('warning'))

                toastr.warning("{{ session('warning') }}");
            @endif
        </script>



    </div>



</body>



</html>
