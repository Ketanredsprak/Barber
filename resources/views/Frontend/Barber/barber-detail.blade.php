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
                <div class="col-sm-6 order-2 order-sm-1">
                    <div class="abt_img">
                        <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid" alt="about">
                    </div>
                    <div class="shape-1">
                        <img src="{{ static_asset('frontend/assets/images/shape-1.png') }}" class="img-fluid"
                            alt="shape">
                    </div>
                </div>

                <div class="col-sm-6 order-1 order-sm-2">
                    <div class="title">
                        <h2>{{ $barber_data->first_name }} {{ $barber_data->last_name }}</h2>
                    </div>
                    <h5>{{ $barber_data->salon_name }}</h5>
                    <p>
                        <i class="fa fa-map-marker"></i> {{ $barber_data->location }} (1 km)
                    <div class="rating">
                        <p><i class="fa fa-star"></i> {{ $barber_data->average_rating }} </p>
                    </div>
                    <p>{{ $barber_data->about_you }}</p>
                    <h5><strong>{{ __('labels.Opening Hours') }}</strong></h5>
                    <p>
                        @if ($barber_data->barber_schedule != '')
                            {{ __('labels.Monday') }} : <strong>
                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif
                            </strong><br>
                            {{-- {{ __('labels.Monday')}} :    <strong>  @if ($barber_data->barber_schedule->monday_is_holiday == 1) {{ __('labels.Holiday') }} @else {{ $barber_data->barber_schedule->monday_start_time}}  - {{ $barber_data->barber_schedule->tuesday_end_time}} @endif </strong><br> --}}
                            {{ __('labels.Tuesday') }} : <strong>
                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif
                            </strong><br>
                            {{-- {{ __('labels.Tuesday')}} :   <strong>  @if ($barber_data->barber_schedule->tuesday_is_holiday == 1) {{ __('labels.Holiday') }} @else {{ $barber_data->barber_schedule->tuesday_start_time}}  - {{ $barber_data->barber_schedule->tuesday_end_time}}  @endif</strong> <br> --}}
                            {{ __('labels.Wednesday') }} : <strong>
                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif
                            </strong><br>
                            {{-- {{ __('labels.Wednesday')}} : <strong>  @if ($barber_data->barber_schedule->wednesday_is_holiday == 1) {{ __('labels.Holiday') }} @else {{ $barber_data->barber_schedule->wednesday_start_time}}  - {{ $barber_data->barber_schedule->wednesday_end_time}}  @endif</strong> <br> --}}
                            {{ __('labels.Thursday') }} : <strong>
                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif
                            </strong><br>
                            {{-- {{ __('labels.Thursday')}} :  <strong>  @if ($barber_data->barber_schedule->thursday_is_holiday == 1) {{ __('labels.Holiday') }} @else {{ $barber_data->barber_schedule->thursday_start_time}}  - {{ $barber_data->barber_schedule->thursday_end_time}}  @endif</strong> <br> --}}
                            {{ __('labels.Friday') }} : <strong>
                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif
                            </strong><br>
                            {{-- {{ __('labels.Friday')}} :    <strong>  @if ($barber_data->barber_schedule->friday_is_holiday == 1) {{ __('labels.Holiday') }} @else {{ $barber_data->barber_schedule->friday_start_time}}  - {{ $barber_data->barber_schedule->friday_end_time}}  @endif</strong> <br> --}}
                            {{ __('labels.Saturday') }} : <strong>
                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif
                            </strong><br>
                            {{-- {{ __('labels.Saturday')}} :  <strong>  @if ($barber_data->barber_schedule->saturday_is_holiday == 1) {{ __('labels.Holiday') }} @else {{ $barber_data->barber_schedule->saturday_start_time}}  - {{ $barber_data->barber_schedule->saturday_end_time}}  @endif</strong> <br> --}}
                            {{ __('labels.Sunday') }} : <strong>
                                @if ($barber_data->barber_schedule->monday_is_holiday == 1)
                                    {{ __('labels.Holiday') }}
                                @else
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_start_time)) }} -
                                    {{ date('h:i A', strtotime($barber_data->barber_schedule->monday_end_time)) }}
                                @endif
                            </strong><br>
                            {{-- {{ __('labels.Sunday')}} :    <strong>  @if ($barber_data->barber_schedule->sunday_is_holiday == 1) {{ __('labels.Holiday') }} @else {{ $barber_data->barber_schedule->sunday_start_time}} - {{ $barber_data->barber_schedule->sunday_end_time}}  @endif</strong><br> --}}
                        @else
                            {{ __('labels.Barber Schedule Not Found.') }}
                        @endif
                    </p>

                    <div class="row image_upload">
                        <div class="col-6 col-sm-12 col-md-6 col-lg-3">
                            <div class="detail-icon">
                                <a href="https://www.google.com/maps?q={{ $barber_data->latitude }},{{ $barber_data->longitude }}"
                                    target="_blank">
                                    <img src="{{ static_asset('frontend/assets/images/map.png') }}" alt="">
                                    <p>{{ __('labels.Maps') }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-sm-12 col-md-6 col-lg-3">
                            <div class="detail-icon">
                                <img src="{{ static_asset('frontend/assets/images/Share.png ') }}" alt="">
                                <p>{{ __('labels.Share') }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-sm-12 col-md-6 col-lg-3">
                            <div class="detail-icon">
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
                    @if (count($barber_data['barber_services']) > 0)
                        @if ($barber_data->barber_schedule != null)
                            <a class="btn btn-success mb-3" type="submit"
                                href="{{ route('get-booking-page', $barber_data->encrypt_id) }}">{{ __('labels.Book Now') }}
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="explore_sec pt-75 pb-75">
        <div class="container">
            <div class="text-left">
                <div class="title">
                    <h2>{{ __('labels.Special Services') }}</h2>
                </div>
            </div>
            <div class="row">



                @if (count($barber_data['barber_services']) > 0)
                    @foreach ($barber_data['barber_services'] as $service)
                        <div class="col-sm-6">
                            <div class="dashboard_right">
                                <div class="whitebox mt-4">
                                    <div class="service_box">
                                        <div class="user">
                                            <img src="{{ static_asset('frontend/assets/images/service_img-icon1.png') }}"
                                                class="img-fluid" alt="review">
                                        </div>
                                        <div class="service_info">
                                            <h5>{{ $service->service_detail->$service_name }}</h5>
                                            <p>{{ $service->sub_service_detail->$service_name }}</p>
                                            <p class="price">${{ $service->service_price }}</p>
                                        </div>
                                    </div>

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

                <div class="col-sm-12 text-center mt-4">
                    <a class="btn btn-success" type="submit"
                        href="{{ route('get-booking-page', $barber_data->encrypt_id) }}">{{ __('labels.Continue') }}</a>
                </div>
              @endif
            @endif
        </div>
    </section>
@endsection
