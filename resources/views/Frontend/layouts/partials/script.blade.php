 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{-- <script src="{{ static_asset('frontend/assets/js/jquery.slim.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ static_asset('frontend/assets/js/popper.min.js') }}"></script>
    <script src="{{ static_asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ static_asset('frontend/assets/js/theme.js') }}"></script>
    <script src="{{ static_asset('frontend/assets/js/owl.carousel.js') }}"></script>
    <script src="{{ static_asset('frontend/assets/js/select2.min.js') }}"></script>
    <script src="{{ static_asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <script>
        $(function() {
            // Owl Carousel
            var owl = $(".owl-carousel");
            owl.owlCarousel({
                items: 1,
                margin: 0,
                loop: true,
                nav: true
            });
        });
    </script>
