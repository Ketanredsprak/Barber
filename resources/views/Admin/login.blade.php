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
    @include('Admin.layouts.partials.head')
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
                        <div><a class="logo text-start text-center" href="javascript:void(0)"><img class="img-fluid for-light text-align-center"
                                    src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt="looginpage"></a></div>
                        <div class="login-main">

                            <form method="POST" action="{{ route('admin-login') }}" class="theme-form">
                                @csrf
                                <h4>{{ __('labels.login') }}</h4>
                                <p>{{ __('labels.Enter your email & password to login') }}</p>

                                <div class="form-group">
                                    <label class="col-form-label">{{ __('labels.Email') }}</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control @error('email') is-invalid @enderror"
                                            type="email" name="email" placeholder="{{ __('labels.Email') }}"  value="{{old('email')}}">
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
                                            type="password" name="password" placeholder="{{ __('labels.Password') }}" value="{{old('password')}}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <input class="btn btn-primary btn-block w-100" type="submit" value="{{ __('labels.Login')}}">
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
