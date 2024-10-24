@extends('Frontend.layouts.app')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN7PVmJtnKlsH164uR42PvclqQyUCqOXE&libraries=places">
</script>


@section('content')
    @php
        $language = config('app.locale');
        $title = 'title_' . $language;
        $sub_title = 'sub_title_' . $language;
        $content = 'content_' . $language;
        $testimonial_content = 'testimonial_content_' . $language;
        $name = 'name_' . $language;
        $service_name = 'service_name_' . $language;
        $designation = 'designation_' . $language;

    @endphp
    <section class="banner_slider">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 px-0">
                    <div id="banner" class="owl-carousel owl-theme">


                        @foreach ($banners as $banner)
                            <div class="item">
                                <div class="slide_box"
                                    style="background-image: url({{ static_asset('banner_image/' . $banner->banner_image) }});">
                                    <div class="banner_info">
                                        <h1>{{ @$banner->$title }}</h1>
                                        <p>{{ @$banner->$content }}</p>
                                        <div class="info_btn">
                                            {{-- <button class="btn btn-warning mr-2"
                                                type="submit">{{ __('labels.Learn More') }}</button> --}}
                                            {{-- <button class="btn btn-outline-light"
                                                type="submit">{{ __('labels.Book No') }}</button> --}}

                                            @if (!empty($banner->barber_info->barber_service) && !empty($banner->barber_info->barber_schedule))
                                                <a class="btn btn-outline-light" type="submit"
                                                    href="{{ route('get-booking-page', $banner->encrypt_id) }}">{{ __('labels.Book Now') }}</a>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="explore_sec pt-75 pb-75">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center mb-4">
                    <div class="head">
                        <h3>{{ $data->cms_content[0]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[0]->$sub_title }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($services as $service)
                    <div class="col-sm-4">
                        <div class="explore_box">
                            <img src="{{ static_asset('service_image/' . $service->service_image) }}" class="img-fluid"
                                alt="explore">
                            <div class="info">
                                <a href="{{ route('barber-list') }}?service_id={{ $service->id }}">
                                    <h4 class="text-center">{{ $service->$service_name }}</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href="{{ route('services') }}" class="btn btn-warning">{{ __('labels.View All Services') }}</a>
                </div>
            </div>

        </div>
    </section>

    <section class="explore_sec pt-75 pb-75" style="background-color: #fcc06015;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mb-4">
                    <div class="head">
                        <h3>{{ $data->cms_content[1]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[1]->$sub_title }}</h2>
                    </div>
                </div>
                <div class="row" id="locationWiseBarberResponse">
                </div>


            </div>
        </div>
        </div>
    </section>

    <section class="explore_sec pt-75 pb-75">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mb-4">
                    <div class="head">
                        <h3>{{ $data->cms_content[2]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[2]->$title }}</h2>
                    </div>
                </div>

                @foreach ($topBarbers as $barber)
                    <div class="col-md-4">
                        <div class="item">
                            <div class="post_box">
                                <div class="top">
                                    <div class="post_img">
                                        <div class="rating">
                                            <p><i class="fa fa-star"></i>
                                                {{ round($barber->barber_ratings_avg_rating, 2) }}</p>
                                        </div>
                                        @php
                                            if (empty($barber->profile_image)) {
                                                $profile_image = 'default.png';
                                            } else {
                                                $profile_image = $barber->profile_image;
                                            }
                                        @endphp
                                        <a href="{{ route('get-booking-page', $barber->encrypt_id) }}">
                                            <img src="{{ static_asset('profile_image/' . $profile_image) }}"
                                                class="img-fluid" alt="post">
                                        </a>
                                    </div>
                                    <div class="post_info">
                                        <h5><a href="{{ route('get-booking-page', $barber->encrypt_id) }}">{{ $barber->first_name }}
                                                - {{ $barber->last_name }}</a>
                                        </h5>
                                        <h4 class="shop_name">{{ $barber->salon_name }}</h4>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <ul class="list-unstyled">
                                        <li> <i class="fa fa-map-marker"></i> {{ $barber->location }} (1 km)</span></li>
                                        @if (!empty($barber->barber_service) && !empty($barber->barber_schedule))
                                            <a class="btn btn-success" type="submit"
                                                href="{{ route('get-booking-page', $barber->encrypt_id) }}">{{ __('labels.Book Now') }}</a>
                                        @endif


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
        </div>
    </section>


    <section class="testimonial_sec pt-75 pb-75"
        style="background: url({{ static_asset('frontend/assets/images/testi_bg.png') }}) no-repeat;background-position: center;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12 text-center">
                    <div class="title">
                        <h2>{{ $data->cms_content[3]->$title }}</h2>
                    </div>
                    <p>{{ $data->cms_content[3]->$content }}</p>
                </div>

                <div class="col-sm-12 col-lg-12">
                    <div class="testimonial-slider owl-carousel owl-theme">

                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimonial_box">
                                    <div class="user">
                                        <div class="user_img">
                                            <img src="{{ static_asset('testimonial_image/' . $testimonial->testimonial_image) }}"
                                                class="img-fluid" alt="user">
                                        </div>
                                    </div>
                                    <p>“{{ $testimonial->$testimonial_content }}” </p>

                                    <div class="user">

                                        <div class="user_info">
                                            <h6 class="name">{{ $testimonial->$name }}</h6>
                                            <p>{{ $testimonial->$designation }}</p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


<script>
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLatitude = position.coords.latitude;
                var userLongitude = position.coords.longitude;

                // sendLocationToServer(userLatitude, userLongitude);
                $('#userLatitude').val(userLatitude);
                $('#userLongitude').val(userLongitude);

                // Send location to the server
                sendLocationToServer(userLatitude, userLongitude);


            }, function(error) {
                console.log("Error retrieving location: ", error);
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }


    function sendLocationToServer(lat, lng) {
        $.ajax({
            url: "{{ route('save-user-location') }}", // Adjust this route as needed
            method: "post",
            data: {
                _token: "{{ csrf_token() }}",
                latitude: lat,
                longitude: lng
            },
            success: function(response) {
                $("#locationWiseBarberResponse").html('');
                $("#locationWiseBarberResponse").append(response);
            },

        });
    }

    // Initialize the map
    initMap();

</script>
