@extends('Frontend.layouts.app')
@section('content')
    @php
        $auth = getauthdata();
        $language = config('app.locale');
        $title = 'title_' . $language;
        $name = 'page_name_' . $language;
        if (empty($auth->profile_image)) {
            $profile_image = 'default.png';
        } else {
            $profile_image = $auth->profile_image;
        }

    @endphp
    <section class="heading_sec"
        style="background-image: url({{ static_asset('frontend/assets/images/banner.png') }});background-position: center;background-repeat: no-repeat;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="heading_title">
                        <h2>{{ $data->$name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="dashboard_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="profile_sidebar">
                        <div class="sidebar_profile">
                            <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid"
                                alt="profsdfzsdfgile">
                            <h3 class="name">{{ $auth->first_name . ' ' . $auth->last_name }}</h3>
                            <hr>

                        </div>


                        <div class="sidebar_nav">
                            @include('Frontend.Auth.sidebar')
                        </div>

                    </div>
                </div>

                <div class="col-lg-9 col-md-8">
                    <div class="dashboard_right">
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="heading_dashboard">
                                    <h3>{{ __('labels.My-Favorites') }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="explore_list">                            
                            <div class="row">


                                @if(count($favorites) > 0)
                                @foreach ($favorites as $favorite)
                                    <div class="col-lg-6">
                                        <div class="item">
                                            <div class="post_box">

                                                <div class="top">
                                                    <div class="post_img">
                                                        <div class="rating">
                                                            <p><i class="fa fa-star"></i> {{ $favorite->barber->rating }}</p>
                                                        </div>
                                                        <a href="{{ route('add-and-remove-favorite', $favorite->barber->id) }}"
                                                            class="fav_icon"><i class="fa fa-heart">
                                                            </i></a>

                                                        @php
                                                            if (empty($favorite->barber->profile_image)) {
                                                                $profile_image = 'default.png';
                                                            } else {
                                                                $profile_image = $favorite->barber->profile_image;
                                                            }
                                                        @endphp

                                                        <img src="{{ static_asset('profile_image/' . @$profile_image) }}"
                                                            class="img-fluid" alt="post">
                                                    </div>
                                                    <div class="post_info">
                                                        <h5> <a class="" type="submit"
                                                            href="{{ route('barber-detail', $favorite->barber->encrypt_id) }}">{{ @$favorite->barber->first_name }}
                                                                {{ @$favorite->barber->last_name }}</a></h5>
                                                        <h4 class="shop_name">{{ @$favorite->barber->salon_name }}
                                                        </h4>
                                                        <ul class="list-unstyled">
                                                            <li> <i class="fa fa-map-marker"></i>
                                                                {{ @$favorite->barber->location }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <a class="" type="submit"
                                                href="{{ route('barber-detail', $favorite->barber->encrypt_id) }}">
                                                <div class="bottom">
                                                    <a class="btn btn-light" type="submit" href="{{ route('barber-detail', $favorite->barber->encrypt_id) }}">{{ __('labels.Book Now') }}</a>
                                                </div>
                                            </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @else
                                <div class="white-box">
                                    <div class="col-sm-12">

                                            <div class="no-record">
                                            <img src="{{ static_asset('frontend/assets/images/no-record.png') }}" class="img-fluid" >
                                            </div>

                                        </div>
                                        </div>

                                @endif



                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    {!! $favorites->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
