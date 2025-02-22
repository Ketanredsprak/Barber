<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">



    <link rel="icon" href="{{ static_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ static_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name') }} - 404 </title>
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
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ static_asset('admin/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/responsive.css') }}">
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        <!-- Maintenance start-->
        <div class="error-wrapper maintenance-bg">
            <div class="container">
                <ul class="maintenance-icons">
                    <li><i class="fa fa-cog"></i></li>
                    <li><i class="fa fa-cog"></i></li>
                    <li><i class="fa fa-cog"></i></li>
                </ul>
                <div class="maintenance-heading">
                    <h2 class="headline">404</h2>
                </div>
                <div><a class="btn btn-primary-gradien btn-lg text-light"
                        href="{{ route('login') }}">{{ __('labels.Back To Home Page') }}</a></div>
            </div>
        </div>
        <!-- Maintenance end-->
    </div>
    <!-- latest jquery-->
    <script src="{{ static_asset('admin/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ static_asset('admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="{{ static_asset('admin/assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ static_asset('admin/assets/js/script.js') }}"></script>
</body>

</html>
