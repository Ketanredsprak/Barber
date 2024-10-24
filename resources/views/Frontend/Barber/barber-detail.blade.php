@extends('Frontend.layouts.app')

@section('content')

    @php

        if (empty($barber_data->profile_image)) {
            $profile_image = 'default.png';
        } else {
            $profile_image = $barber_data->profile_image;
        }

        $language = config('app.locale');

        $name = 'page_name_' . $language;

        $service_name = 'service_name_' . $language;

    @endphp


    <style>
        .home-demo .item {
            background: #ffffff;
        }

        .home-demo h2 {
            color: #252222;
            text-align: center;
            padding: 5rem 0;
            margin: 0;
            font-style: italic;
            font-weight: 300;
        }

          /* Wrapper for profile image and name */
          .profile-image-wrapper {
            display: flex;
            align-items: center;
        }

        /* Small profile image with circular shape */
        .small-profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            /* Adds space between image and name */
            object-fit: cover;
            /* Ensures the image covers the entire circle */
            border: 2px solid #ff3f4d;
            /* Optional: Adds a border around the image */
        }

        .barber-info .name {
            font-size: 1.2rem;
            margin: 0;
            font-weight: 600;
        }

        .barber-info .designation,
        .barber-info .rating,
        .barber-info .location {
            margin: 5px 0;
        }

        .barber-info .btn-light {
            margin-top: 10px;
        }

    </style>

    <section class="heading_sec"
        style="background-image: url({{ static_asset('frontend/assets/images/banner.png') }});background-position: center;background-repeat: no-repeat;background-size: cover;">

        <div class="container">

            <div class="row">

                <div class="col-sm-12 text-center">

                    <div class="heading_title">

                        <h2>{{ $barber_data->$name }}</h2>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <section class="about_wrap pt-75 pb-75">



        <div class="container">

            <div class="row">

                <div class="col-lg-6 order-2 order-lg-1">

                    <div class="abt_img">

                        {{-- <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid main-img" alt="about"> --}}



                        @if (count($barber_data->barber_images) > 0)
                            <div class="home-demo">
                                <div class="owl-carousel owl-theme">

                                    @foreach ($barber_data->barber_images as $image)
                                        <div class="item">
                                            <img src="{{ static_asset('barber_images/' . $image->image) }}" alt="Image 1"
                                                style="height: 380px; width: 500px;">
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                        @else
                            <div class="item">
                                <img src="{{ static_asset('barber_images/no-image.jpg') }}" alt="Image 1"
                                    style="height: 380px; width: 500px;">
                            </div>
                        @endif

                    </div>

                    <div class="shape-1">

                        <img src="{{ static_asset('frontend/assets/images/shape-1.png') }}" class="img-fluid"
                            alt="shape">

                    </div>

                </div>



                <div class="col-lg-6 order-1 order-lg-2">


                    <div class="title m-0">
                        <h3 class="name">{{ $barber_data->first_name }} {{ $barber_data->last_name }}</h3>
                    </div>

                    <h5>{{ $barber_data->salon_name }}</h5>

                    <p class="rating"><i class="fa fa-star"></i> {{ $barber_data->average_rating }} </p>

                    <div>
                        <a class="location"
                            href="https://www.google.com/maps?q={{ $barber_data->latitude }},{{ $barber_data->longitude }}"
                            target="_blank">
                            <i class="fa fa-map-marker"></i> {{ $barber_data->location }} (1 km)
                        </a>
                    </div>

                    <p>{{ $barber_data->about_you }}</p>

                    <h5 class="time-head">{{ __('labels.Opening Hours') }}</h5>

                    <p class="available-time">

                        @if ($barber_data->barber_schedule != '')
                            <span>{{ __('labels.Monday') }} :</span><strong>

                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -

                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif

                            </strong><br>

                            <span>{{ __('labels.Tuesday') }} : </span><strong>

                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -

                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif

                            </strong><br>

                            <span>{{ __('labels.Wednesday') }} : </span><strong>

                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -

                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif

                            </strong><br>

                            <span>{{ __('labels.Thursday') }} : </span><strong>

                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -

                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif

                            </strong><br>

                            <span>{{ __('labels.Friday') }} : </span><strong>

                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -

                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif

                            </strong><br>

                            <span>{{ __('labels.Saturday') }} : </span><strong>

                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -

                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif

                            </strong><br>

                            <span>{{ __('labels.Sunday') }} : </span><strong>

                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -

                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif

                            </strong><br>

                            <span>
                            @else
                                {{ __('labels.Barber Schedule Not Found.') }}
                        @endif
                        </span>

                    </p>


                    <div class="btns-wrapper">
                        <div>
                            @if (count($barber_data['barber_services']) > 0)
                                @if ($barber_data->barber_schedule != null)
                                    <a class="btn btn-light mb-3" type="submit"
                                        href="{{ route('get-booking-page', $barber_data->encrypt_id) }}">{{ __('labels.Book Now') }}

                                    </a>
                                @endif
                            @endif
                        </div>

                        <div class="detail-icons-wrapper">
                            <div>
                                <a href="javascript:void(0);" onclick="HideShowSocial();">

                                    <img src="{{ static_asset('frontend/assets/images/Share.png') }}" alt="Share"
                                        class="share-image">

                                    <p>{{ __('labels.Share') }}</p>

                                </a>



                                @php

                                    $url = url()->current();

                                    $title = $barber_data->first_name . ' ' . $barber_data->last_name;

                                @endphp


                                <ul class="socialList" style="display:none;">
                                    <li> <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                                            target="_blank" rel="noopener noreferrer"><i
                                                class="fa-brands fa-facebook-f"></i></a></li>

                                    <li> <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ urlencode($title) }}"
                                            target="_blank" rel="noopener noreferrer"><i
                                                class="fa-brands fa-twitter"></i></a></li>

                                    <li> <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($url) }}"
                                            target="_blank" rel="noopener noreferrer"><i
                                                class="fa-brands fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                            <div>
                                <a href="{{ route('add-and-remove-favorite', $barber_data->id) }}">
                                    @if ($check_favorite_list)
                                        <img src="{{ static_asset('frontend/assets/images/heart.png') }}" alt="">
                                    @else
                                        <img src="{{ static_asset('frontend/assets/images/favroite.png') }}"
                                            alt="">
                                    @endif
                                    <p>{{ __('labels.Favorite') }}</p>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>



    <section class="explore_sec pb-75">

        <div class="container">
            <div class="title">
                <h2>{{ __('labels.Services') }}</h2>
            </div>

            <div class="row">

                @if (count($barber_data['barber_services']) > 0)
                    @foreach ($barber_data['barber_services'] as $service)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="service_box">
                                <div class="user">
                                    <img src="{{ static_asset('service_image/' . $service->service_detail->service_image) }}"
                                        class="img-fluid" alt="review">
                                </div>

                                <div class="service_info">
                                    <h5>{{ $service->service_detail->$service_name }}</h5>

                                    <p>{{ $service->sub_service_detail->$service_name }}</p>

                                    <p class="price">${{ $service->service_price }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-sm-12 text-center">

                        <h4>{{ __('labels.No service added by barber') }}</h4>

                    </div>
                @endif





            </div>

            @if (count($barber_data['barber_services']) > 0)
                @if ($barber_data->barber_schedule != null)
                    <div class="col-sm-12 text-center mt-md-4 mt-2">

                        <a class="btn btn-success" type="submit"
                            href="{{ route('get-booking-page', $barber_data->encrypt_id) }}">{{ __('labels.Book Now') }}</a>

                        <a class="btn btn-warning" type="submit"
                            href="{{ route('barber-list') }}">{{ __('labels.Back') }}</a>

                    </div>
                @endif
            @endif

        </div>

    </section>

@endsection





<style>
    .socialList {

        list-style: none;

        margin: 0;

        padding: 0;

        display: flex;

        justify-content: flex-start;

        justify-content: center;

        flex-flow: row wrap;

        li {

            margin: 5px;

            &:first-child {

                padding-left: 0;

            }

            a {

                position: relative;

                display: flex;

                justify-content: center;

                align-items: center;

                width: 50px;

                height: 50px;

                border-radius: 100%;

                text-decoration: none;

                background-color: #999;

                color: #fff;

                transition: .35s;

                i {

                    position: absolute;

                    top: 50%;

                    left: 50%;

                    transform-origin: top left;

                    transform: scale(1) translate(-50%, -50%);

                    transition: .35s;

                }

                &:hover {

                    i {

                        transform: scale(1.5) translate(-50%, -50%);

                    }

                }

            }

            &:nth-child(1) a {

                background-color: #135cb6;

            }

            &:nth-child(2) a {

                background-color: #00aced;

            }

            &:nth-child(3) a {

                background-color: #0077B5;

            }

            &:nth-child(4) a {

                background-color: #111111;

            }

            &:nth-child(5) a {

                background-color: #1FB381;

            }

        }

    }
</style>



<script>
    function HideShowSocial() {

        $(".socialList").toggle();

    }

    $(function() {
        // Owl Carousel
        var owl = $(".owl-carousel");
        owl.owlCarousel({
            items: 3,
            margin: 10,
            loop: true,
            nav: true
        });
    });
</script>
