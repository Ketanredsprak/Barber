@php
    $currentRouteName = Route::currentRouteName();
    $locale = config('app.locale');
    $meta_keyword = 'meta_title_' . $locale;
    $meta_description = 'meta_content_' . $locale;
@endphp
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="{{ $data->meta_content->$meta_keyword ?? '' }}">
<meta name="keywords" content="{{ $data->meta_content->$meta_description ?? '' }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@php
    use Illuminate\Support\Str;
    // Get the current route name and format it
    $formattedRouteName = Str::title(str_replace('-', ' ', $currentRouteName));
    if ($formattedRouteName == 'Index') {
        $page_name = 'Home';
    } else {
        $page_name = $formattedRouteName;
    }

@endphp
<title>{{ config('app.name') }} - {{ $page_name }}</title>




<!--
=====================================================================
FAVICON
=====================================================================
-->

<link rel="icon" href="{{ static_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ static_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
<meta name="msapplication-TileColor" content="#79bde9">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">

<!--
=====================================================================
CSS
=====================================================================
-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,300..700;1,300..700&display=swap"
    rel="stylesheet">


<link rel="stylesheet" type="text/css" href="{{ static_asset('frontend/assets/styles/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ static_asset('frontend/assets/styles/custom.css') }}">
<link rel="stylesheet" type="text/css" href="{{ static_asset('frontend/assets/styles/layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ static_asset('frontend/assets/styles/fonts.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="{{ static_asset('frontend/assets/styles/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ static_asset('frontend/assets/styles/line-awesome.min.css') }}">

<!-----  Toastr Css---->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-----  Toastr Css Ends---->


<!-- Owl Stylesheets -->
<link rel="stylesheet" href="{{ static_asset('frontend/assets/styles/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ static_asset('frontend/assets/styles/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ static_asset('frontend/assets/styles/select2.min.css') }}">


<!--
=====================================================================
JS
=====================================================================
-->

<script src="{{ static_asset('frontend/assets/js/modernizr.js') }}"></script>
