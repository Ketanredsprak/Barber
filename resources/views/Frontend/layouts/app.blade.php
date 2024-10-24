<!doctype html>
@php
    $locale = config('app.locale');
    $dir = in_array($locale, ['ar', 'ur']) ? 'rtl' : 'ltr';
@endphp
<html class="nojs" lang="{{ $locale }}" dir="{{ $dir }}">
<?php
$locale = config('app.locale');
$config = getWebsiteConfig();
?>


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

        function change_lang(lang) {
            var data = lang;
            $.ajax({
                type: 'POST',
                headers: {
                    'XSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{ route('language.change') }}',
                data: {
                    data: lang,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(response) {
                    alert("errror");
                }
            });
        }



        $(document).ready(function () {
        $(window).resize(function () {
            $('.line').width(($(window).width() - $('.text').width() * 2) / 3 - 8);
        });
        $('.line').width(($(window).width() - $('.text').width() * 2) / 3 - 8);
        })


    </script>


    <!-- script -->
    @yield('footer-script')
    <!-- /.script -->


</body>

</html>


<!-- Custom Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">{{ __('labels.Confirmation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="confirmationMessage">
                <!-- Message will be dynamically inserted here -->
                {{-- {{ __('message.Are you sure you want to logout from website?') }} --}}
                {{ __('message.Are you sure to logout?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('labels.No') }}</button>
                <button type="button" class="btn btn-primary" id="confirmYesButton">{{ __('labels.Yes') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- Custom Confirmation Modal -->


<!-- Custom Confirmation Modal -->
<div class="modal fade" id="confirmationModal1" tabindex="-1" role="dialog" aria-labelledby="confirmationModal1Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModal1Label">{{ __('labels.Confirmation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="confirmationMessage">
                <!-- Message will be dynamically inserted here -->
                {{ __('message.Are you sure you resend otp from website?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('labels.No') }}</button>
                <button type="button" class="btn btn-primary" id="confirmYesButton1">{{ __('labels.Yes') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- Custom Confirmation Modal -->
