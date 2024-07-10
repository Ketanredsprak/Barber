@extends('Frontend.layouts.app')
@section('content')

@php
if (empty($data->profile_image)) {
    $profile_image = 'default.png';
} else {
    $profile_image = $data->profile_image;
}

$language = config('app.locale');
$name = 'page_name_' . $language;

@endphp

    <section class="heading_sec"
        style="background-image: url({{ static_asset('frontend/assets/images/banner.png') }});background-position: center;background-repeat: no-repeat;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="heading_title">
                        <h2> {{ $page_data->$name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about_wrap pt-75 pb-75">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 order-2 order-sm-1">
                    <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid" alt="about">
                </div>

                <div class="col-sm-6 order-1 order-sm-2">

                    <div class="title">
                        <h2>{{ $data->first_name }} {{ $data->last_name }}</h2>
                    </div>
                    <h5>{{ $data->salon_name }}</h5>
                    <p>
                        <i class="fa fa-map-marker"></i> {{ $data->location }} (1 km)</span>
                    <div class="rating">
                        <p><i class="fa fa-star"></i> 4.5</p>
                    </div>
                    <p>{{ $data->about_you }}</p>
                    <h5>Opening Hours</h5>
                    <p>Monday - Friday : <strong>09.00 am - 08.00 pm </strong> <br>
                        Monday - Friday : <strong> 09.00 am - 09.00 pm </strong></p>

                    <div class="row image_upload">
                        <div class="col-6 col-sm-12 col-md-6 col-lg-3">
                            <div class="detail-icon">
                                <img src="{{ static_asset('frontend/assets/images/map.png') }}" alt="">
                                <p>Maps</p>
                            </div>
                        </div>
                        <div class="col-6 col-sm-12 col-md-6 col-lg-3">
                            <div class="detail-icon">
                                <img src="{{ static_asset('frontend/assets/images/Share.png') }}" alt="">
                                <p>Share</p>
                            </div>
                        </div>
                        <div class="col-6 col-sm-12 col-md-6 col-lg-3">
                            <div class="detail-icon">
                               <a href="{{ route('add-and-remove-favorite', $data->id) }}">
                                @if($check_favorite_list)
                                <img src="{{ static_asset('frontend/assets/images/favroite.png') }}" alt="">
                                @else
                                <img src="{{ static_asset('frontend/assets/images/heart.png') }}" alt="">
                                @endif

                                <p>Favorite</p></a>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit">Book Now</button>
                </div>
            </div>
        </div>
    </section>

    <section class="explore_sec pt-75 pb-75">
        <div class="container">
            <div class="text-left">
                <div class="title">
                    <h2>Special Services</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="dashboard_right">
                        <div class="whitebox mt-4">
                            <div class="service_box">
                                <div class="user">
                                    <img src="{{ static_asset('frontend/assets/images/service_img-icon1.png') }}" class="img-fluid" alt="review">
                                </div>
                                <div class="service_info">
                                    <h5>Hair & Beard Trim</h5>
                                    <p>Haircut & vitamint</p>
                                    <p class="price">$13.00</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dashboard_right">
                        <div class="whitebox mt-4">
                            <div class="service_box">
                                <div class="user">
                                    <img src="{{ static_asset('frontend/assets/images/service_img-icon2.png') }}" class="img-fluid" alt="review">
                                </div>
                                <div class="service_info">
                                    <h5>Skin</h5>
                                    <p>Additional massage</p>
                                    <p class="price">$13.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="dashboard_right">
                        <div class="whitebox mt-4">
                            <div class="service_box">
                                <div class="user">
                                    <img src="{{ static_asset('frontend/assets/images/service_img-icon3.png') }}" class="img-fluid" alt="review">
                                </div>
                                <div class="service_info">
                                    <h5>Hair Treatment</h5>
                                    <p>Special full treatment</p>
                                    <p class="price">$13.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dashboard_right">
                        <div class="whitebox mt-4">
                            <div class="service_box">
                                <div class="user">
                                    <img src="{{ static_asset('frontend/assets/images/service_img-icon4.png') }}" class="img-fluid" alt="review">
                                </div>
                                <div class="service_info">
                                    <h5>Children’s</h5>
                                    <p>Special kids haircut</p>
                                    <p class="price">$13.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="dashboard_right">
                        <div class="whitebox mt-4">
                            <div class="service_box">
                                <div class="user">
                                    <img src="{{ static_asset('frontend/assets/images/service_img-icon3.png') }}" class="img-fluid" alt="review">
                                </div>
                                <div class="service_info">
                                    <h5>Body</h5>
                                    <p>Special full treatment</p>
                                    <p class="price">$13.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 text-center mt-4">
                <button class="btn btn-success" type="submit">Continue</button>
            </div>
        </div>
    </section>
@endsection
