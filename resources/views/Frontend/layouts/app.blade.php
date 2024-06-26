<!doctype html>
<html class="nojs">


<head>
 <!--begin::Frontend Head wrapper-->
 @include('Frontend.layouts.partials.head')
 <!--end::Frontend Head wrapper-->
</head>

<body>

    <!--================================================================
        HEADER
==========================================================-->

    <header class="header fixed-top">
                    <!--begin::Frontend Head wrapper-->
                    @include('Frontend.layouts.partials.navbar')
                    <!--end::Frontend Head wrapper-->
    </header>


    <div class="page-body">
            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
    </div>

    <footer class="footer"
        style="background-color: #1C2749;background-position: center;background-repeat: no-repeat;background-size: cover;">
                    <!--begin::Frontend Footer wrapper-->
                    @include('Frontend.layouts.partials.footer')
                    <!--end::Frontend Footer wrapper-->
    </footer>

     <!--begin::Frontend Script wrapper-->
     @include('Frontend.layouts.partials.script')
     <!--end::Frontend Script wrapper-->


</body>

</html>
