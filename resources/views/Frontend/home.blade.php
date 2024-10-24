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

        $locale = config('app.locale');
        $dir = in_array($locale, ['ar', 'ur']) ? 'rtl' : 'ltr';

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
                                    <div class="container content-main-wrapper">
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
                                                        href="{{ route('get-booking-page', $banner->encrypt_id) }}">{{ __('labels.Book Now') }}
                                                    </a>
                                                @endif

                                            </div>
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

    <input type="text" name="lat" id="lat" value="{{ @$lat }}">
    <input type="text" name="long" id="long" value="{{ @$long }}">


    <section class="explore_sec pt-75 pb-75">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
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
                    <div class="col-lg-4 col-sm-6">
                        <a href="{{ route('barber-list') }}?service_id={{ $service->id }}">
                            <div class="explore_box">
                                <img src="{{ static_asset('service_image/' . $service->service_image) }}" class="img-fluid"
                                    alt="explore">
                                <div class="info">
                                    <h4 class="text-center">{{ $service->$service_name }}</h4>
                                </div>
                            </div>
                        </a>
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
                <div class="col-sm-12">
                    <div class="head">
                        <h3>{{ $data->cms_content[1]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[1]->$sub_title }}</h2>
                    </div>
                </div>
            </div>
            <div class="row" id="locationWiseBarberResponse">
            </div>
        </div>
        </div>
    </section>

    <section class="explore_sec pt-75 pb-75">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="head">
                        <h3>{{ $data->cms_content[2]->$title }}</h3>
                    </div>
                    <div class="title">
                        <h2>{{ $data->cms_content[2]->$title }}</h2>
                    </div>
                </div>
            </div>
            <div class="row" id="ratingWiseBarberResponse">
            </div>
        </div>
        </div>
    </section>


    <section class="testimonial_sec pt-75 pb-75"
        style="background: url({{ static_asset('frontend/assets/images/testi_bg.png') }}) no-repeat;background-position: center;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12 text-center">
                    <div class="title mb-0">
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
    document.addEventListener("DOMContentLoaded", function() {
        // Make sure the DOM is fully loaded before calling initMap
        initMap();
    });

    function initMap() {
        // alert("hello"); // This should show when the function is called

        // Check if the DOM elements exist before accessing them
        var userLatitudeElement = document.getElementById('lat');
        var userLongitudeElement = document.getElementById('long');

        if (!userLatitudeElement || !userLongitudeElement) {
            // alert('Latitude or Longitude input elements not found');
            return;
        }

        var userLatitude = userLatitudeElement.value;
        var userLongitude = userLongitudeElement.value;

        // alert(userLatitude); // This should show the value from the 'lat' input field
        // alert(userLongitude); // This should show the value from the 'long' input field

        if (userLatitude && userLongitude) {
            // If coordinates are found in cookies, send them to the server
            sendLocationToServer(userLatitude, userLongitude);
            sendLocationToServerForRating(userLatitude, userLongitude);
        } else {
            // If cookies are not found, ask for location access
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    userLatitude = position.coords.latitude;
                    userLongitude = position.coords.longitude;

                    // Store the coordinates in hidden fields
                    document.getElementById('lat').value = userLatitude;
                    document.getElementById('long').value = userLongitude;

                    // Send the location to the server
                    sendLocationToServer(userLatitude, userLongitude);
                    sendLocationToServerForRating(userLatitude, userLongitude);

                }, function(error) {
                    console.log("Error retrieving location: ", error);
                });
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }
    }

    function sendLocationToServer(lat, lng) {
        $.ajax({
            url: "{{ route('nearest-barber-list') }}", // Adjust this route as needed
            method: "post",
            data: {
                _token: "{{ csrf_token() }}",
                latitude: lat,
                longitude: lng
            },
            success: function(response) {
                $("#locationWiseBarberResponse").html('');
                $("#locationWiseBarberResponse").append(response);
            }
        });
    }


    function sendLocationToServerForRating(lat, lng) {
        $.ajax({
            url: "{{ route('rating-barber-list') }}", // Adjust this route as needed
            method: "post",
            data: {
                _token: "{{ csrf_token() }}",
                latitude: lat,
                longitude: lng
            },
            success: function(response) {
                $("#ratingWiseBarberResponse").html('');
                $("#ratingWiseBarberResponse").append(response);
            }
        });
    }
</script>
