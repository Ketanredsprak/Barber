@extends('Frontend.layouts.app')
@section('content')
    @php
        $auth = getauthdata();
        $language = config('app.locale');
        $title = 'title_' . $language;
        $name = 'page_name_' . $language;
        $service_name = 'service_name_' . $language;
        if (empty($auth->profile_image)) {
            $profile_image = 'default.png';
        } else {
            $profile_image = $auth->profile_image;
        }

        // dd($booking->can_reschedule,$booking->can_cancel);
    @endphp


    <style>
        .checked {
            color: orange;
        }

        .icon {
            font-size: 36px;
        }
    </style>



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
                <div class="col-sm-3 col-lg-3">
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

                <div class="col-sm-9 col-lg-9">
                    <div class="dashboard_right">
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="heading_dashboard">
                                    <h3>{{ __('labels.My Booking') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="whitebox">


                            <?php

                            if (empty($booking->barber_detail->profile_image)) {
                                $profile_image = 'default.png';
                            } else {
                                $profile_image = $booking->barber_detail->profile_image;
                            }
                            ?>



                            @if (in_array($booking->status, ['accept', 'finished']))
                                @if (in_array($booking->process_status, ['booked', 'waiting', 'in progress', 'finished']))
                                    <div class="status-bar">
                                        <ul class="questions quesions--medium">
                                            <li class="@if ($booking->process_status == 'booked') is-active @elseif(in_array($booking->process_status, ['waiting', 'in progress', 'finished'])) is-complete @endif"
                                                data-step="">
                                                {{ __('labels.Booked') }}
                                            </li>
                                            <li data-step=""
                                                class="@if ($booking->process_status == 'waiting') is-active @elseif(in_array($booking->process_status, ['in progress', 'finished'])) is-complete @endif">
                                                {{ __('labels.Waiting') }}
                                            </li>
                                            <li data-step=""
                                                class="@if ($booking->process_status == 'in progress') is-active @elseif($booking->process_status == 'finished') is-complete @endif">
                                                {{ __('labels.In Process') }}
                                            </li>
                                            <li data-step="" class="@if ($booking->process_status == 'finished') is-active @endif">
                                                {{ __('labels.Finished') }}
                                            </li>
                                        </ul>
                                    </div>
                                @endif




                                @if ($booking->process_status == 'booked')
                                    <div class="mybarber_list">
                                        <div class="user">
                                            <img src="{{ static_asset('profile_image/' . $profile_image) }}"
                                                class="img-fluid" alt="user">
                                        </div>
                                        <div class="info">
                                            <div class="mybarber_head">
                                                <h6>{{ $booking->barber_detail->first_name ?? '' }}
                                                    {{ $booking->barber_detail->last_name ?? '' }}</h6>
                                            </div>
                                            <h4 class="view-title">{{ __('labels.Status') }} :
                                                @if ($booking->status == 'pending')
                                                    {{ __('labels.Pending') }}
                                                @elseif ($booking->status == 'cancel')
                                                    {{ __('labels.Cancel') }}
                                                @elseif($booking->status == 'reject')
                                                    {{ __('labels.Reject') }}
                                                @elseif($booking->status == 'accept')
                                                    {{ __('labels.Accept') }}
                                                @elseif($booking->status == 'finished')
                                                    {{ __('labels.Finished') }}
                                                @elseif($booking->status == 'rescheduled')
                                                    {{ __('labels.Rescheduled') }}
                                                @endif



                                            </h4>
                                            <p>{{ $booking->barber_detail->gender ?? '' }} </p>


                                            <p class="date mb-0 text-warning"></p>
                                            <div class="mybarber_head2">

                                                <div class="row image_upload">
                                                    <div class="col-6 col-sm-12 col-md-6">
                                                        <div class="detail-icon">
                                                            <img src="{{ static_asset('frontend/assets/images/loc-map.png') }}"
                                                                alt="">
                                                            <br>
                                                            <a href="https://www.google.com/maps?q={{ $booking->barber_detail->latitude }},{{ $booking->barber_detail->longitude }}"
                                                                target="_blank">
                                                                {{ $booking->barber_detail->location ?? '' }}

                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-12 col-md-6">
                                                        <div class="detail-icon">
                                                            <a href="{{ route('my-chat') }}"><img
                                                                    src="{{ static_asset('frontend/assets/images/chat.png') }}"
                                                                    alt="">
                                                                <p>{{ __('labels.Chat') }} </p>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>



                                                <div class="schedule_btn">
                                                    @if ($booking->can_reschedule == 1)
                                                        @if ($booking->is_reschedule == 0)
                                                            <a class="btn btn-success text-white reschedule-booking mx-2"
                                                                data-id="{{ $booking->booking_encrypt_id }}"
                                                                href="javascript:void(0)">{{ __('labels.Reschedule') }}</a>
                                                        @endif
                                                    @endif
                                                    @if ($booking->can_cancel == 1)
                                                        <a class="btn btn-success text-white cancel-booking"
                                                            data-id="{{ $booking->booking_encrypt_id }}"
                                                            href="javascript:void(0)">{{ __('labels.Cancel') }}</a>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <ul class="list-unstyled mybarber_info mt-3 p-0">
                                            <li> <i><img
                                                        src="{{ static_asset('frontend/assets/images/calender.png') }}"></i><span>
                                                    <div class="mybarber_head">
                                                        <h6>{{ __('labels.Date & Time') }}</h6>
                                                    </div>
                                                </span></li>
                                        </ul>
                                        <p class="mt-0">{{ date('d-M-Y', strtotime($booking->booking_date)) }},
                                            {{ date('h:i A', strtotime($booking->start_time)) }} -
                                            {{ date('h:i A', strtotime($booking->end_time)) }}</p>

                                        <ul class="list-unstyled mybarber_info mt-3 p-0">
                                            <li> <i><img
                                                        src="{{ static_asset('frontend/assets/images/scissors.png') }}"></i><span>
                                                    <div class="mybarber_head">
                                                        <h6>{{ __('labels.Service Selected') }}</h6>
                                                    </div>
                                                </span></li>
                                        </ul>

                                        @if (!empty($booking->booking_service_detailss))
                                            <div class="info2">
                                                @foreach ($booking->booking_service_detailss as $service)
                                                    <div class="mybarber_head">
                                                        <h6>{{ $service->main_service->$service_name }}</h6>
                                                    </div>
                                                    <p>{{ $service->sub_service->$service_name }}</p>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        @endif


                                        <div class="mybarber_head mt-3">
                                            <h6>{{ $booking->barber_detail->salon_name ?? '' }}</h6>
                                        </div>
                                        <?php /*
                                        <p>
                                            <i><img src="{{ static_asset('frontend/assets/images/loc-map.png') }}"></i>
                                            {{ $booking->barber_detail->location ?? '' }} </span>
                                        </p>
                                        */
                                        ?>
                                        <div class="rating">
                                            <p><i><img src="{{ static_asset('frontend/assets/images/star-3.png') }}"></i>
                                                {{ $barber_data->average_rating }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($booking->process_status == 'waiting')
                                    <div class="mybarber_list">
                                        <div class="user">
                                            <img src="{{ static_asset('profile_image/' . $profile_image) }}"
                                                class="img-fluid" alt="user">
                                        </div>
                                        <div class="info">
                                            <div class="mybarber_head">
                                                <h6>{{ $booking->barber_detail->first_name ?? '' }}
                                                    {{ $booking->barber_detail->last_name ?? '' }}</h6>
                                            </div>
                                            <h4 class="view-title">{{ __('labels.Status') }} :
                                                @if ($booking->status == 'pending')
                                                    {{ __('labels.Pending') }}
                                                @elseif ($booking->status == 'cancel')
                                                    {{ __('labels.Cancel') }}
                                                @elseif($booking->status == 'reject')
                                                    {{ __('labels.Reject') }}
                                                @elseif($booking->status == 'accept')
                                                    {{ __('labels.Accept') }}
                                                @elseif($booking->status == 'finished')
                                                    {{ __('labels.Finished') }}
                                                @elseif($booking->status == 'rescheduled')
                                                    {{ __('labels.Rescheduled') }}
                                                @endif
                                            </h4>
                                            <p>{{ $booking->barber_detail->gender ?? '' }} </p>
                                            <p class="date mb-0 text-warning"></p>
                                            <div class="mybarber_head2">
                                                <div class="row image_upload">
                                                    <div class="col-6 col-sm-12 col-md-6">
                                                        <div class="detail-icon">
                                                            <img src="{{ static_asset('frontend/assets/images/map.png') }}"
                                                                alt="">
                                                            <br>
                                                            <a href="https://www.google.com/maps?q={{ $booking->barber_detail->latitude }},{{ $booking->barber_detail->longitude }}"
                                                                target="_blank">
                                                                {{ $booking->barber_detail->location ?? '' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-12 col-md-6">
                                                        <div class="detail-icon">
                                                            <a href="{{ route('my-chat') }}"><img
                                                                    src="{{ static_asset('frontend/assets/images/chat.png') }}"
                                                                    alt="">
                                                                <p>{{ __('labels.Chat') }}</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="schedule_btn">
                                                    @if ($booking->can_reschedule == 1)
                                                        @if ($booking->is_reschedule == 0)
                                                            <a class="btn btn-success text-white reschedule-booking mx-2"
                                                                data-id="{{ $booking->booking_encrypt_id }}"
                                                                href="javascript:void(0)">{{ __('labels.Reschedule') }}</a>
                                                        @endif
                                                    @endif
                                                    @if ($booking->can_cancel == 1)
                                                        <a class="btn btn-success text-white cancel-booking"
                                                            data-id="{{ $booking->booking_encrypt_id }}"
                                                            href="javascript:void(0)">{{ __('labels.Cancel') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info mt-3">
                                            <ul class="list-unstyled mybarber_info mb-0">
                                                <li>
                                                    <div class="time-estimate">
                                                        <h6>{{ __('labels.Time Estimation') }}</h6>
                                                        <p>-{{ $booking->minute_start_and_end_minute_left ?? '' }}
                                                            {{ __('labels.Min') }}</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="list-unstyled mybarber_info mt-3 p-0">
                                            <li> <i><img
                                                        src="{{ static_asset('frontend/assets/images/calender.png') }}"></i><span>
                                                    <div class="mybarber_head">
                                                        <h6>{{ __('labels.Date & Time') }}</h6>
                                                    </div>
                                                </span></li>
                                        </ul>
                                        <p class="mt-0"> {{ date('d-M-Y', strtotime($booking->booking_date)) }},
                                            {{ date('h:i A', strtotime($booking->start_time)) }} -
                                            {{ date('h:i A', strtotime($booking->end_time)) }} </p>

                                        <ul class="list-unstyled mybarber_info mt-3 p-0">
                                            <li> <i><img
                                                        src="{{ static_asset('frontend/assets/images/scissors.png') }}"></i><span>
                                                    <div class="mybarber_head">
                                                        <h6>{{ __('labels.Service Selected') }}</h6>
                                                    </div>
                                                </span></li>
                                        </ul>

                                        @if (!empty($booking->booking_service_detailss))
                                            <div class="info2">
                                                @foreach ($booking->booking_service_detailss as $service)
                                                    <div class="mybarber_head">
                                                        <h6>{{ $service->main_service->$service_name }}</h6>
                                                    </div>
                                                    <p>{{ $service->sub_service->$service_name }}</p>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="mybarber_head mt-3">
                                            <h6>{{ $service->barber_detail->salon_name ?? '' }}</h6>
                                        </div>
                                        <?php /*
                                        <p>
                                            <i><img src="{{ static_asset('frontend/assets/images/loc-map.png') }}"
                                                    alt=""></i> {{ $service->barber_detail->salon_name ?? '' }} (2
                                            km)
                                        </p>
                                        */
                                        ?>
                                        <div class="rating">
                                            <p><i><img src="{{ static_asset('frontend/assets/images/star-3.png') }}"
                                                        alt=""></i> {{ $barber_data->average_rating }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($booking->process_status == 'in progress')
                                    <div class="mybarber_list">
                                        <div class="user">
                                            <img src="{{ static_asset('profile_image/' . $profile_image) }}"
                                                class="img-fluid" alt="user">
                                        </div>
                                        <div class="info">
                                            <div class="mybarber_head">
                                                <h6>{{ $booking->barber_detail->first_name ?? '' }}
                                                    {{ $booking->barber_detail->last_name ?? '' }}</h6>
                                            </div>
                                            <h4 class="view-title">{{ __('labels.Status') }} :
                                                @if ($booking->status == 'pending')
                                                    {{ __('labels.Pending') }}
                                                @elseif ($booking->status == 'cancel')
                                                    {{ __('labels.Cancel') }}
                                                @elseif($booking->status == 'reject')
                                                    {{ __('labels.Reject') }}
                                                @elseif($booking->status == 'accept')
                                                    {{ __('labels.Accept') }}
                                                @elseif($booking->status == 'finished')
                                                    {{ __('labels.Finished') }}
                                                @elseif($booking->status == 'rescheduled')
                                                    {{ __('labels.Rescheduled') }}
                                                @endif
                                            </h4>
                                            <p>{{ $booking->barber_detail->gender ?? '' }} </p>


                                            <p class="date mb-0 text-warning"></p>
                                            <div class="mybarber_head2">

                                                <div class="row image_upload">
                                                    <div class="col-6 col-sm-12 col-md-6">
                                                        <div class="detail-icon">
                                                            <img src="{{ static_asset('frontend/assets/images/map.png') }}"
                                                                alt="">
                                                            <br>
                                                            <a href="https://www.google.com/maps?q={{ $booking->barber_detail->latitude }},{{ $booking->barber_detail->longitude }}"
                                                                target="_blank">
                                                                {{ $booking->barber_detail->location ?? '' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-12 col-md-6">
                                                        <div class="detail-icon">
                                                            <a href="{{ route('my-chat') }}"><img
                                                                    src="{{ static_asset('frontend/assets/images/chat.png') }}"
                                                                    alt="">
                                                                <p>{{ __('labels.Chat') }}</p>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="info mt-3">
                                            <ul class="list-unstyled mybarber_info mb-0">
                                                <li><span>
                                                        <div class="time-estimate">
                                                            <h6>{{ __('labels.In-Process') }}</h6>
                                                            <p>{{ $booking->minute_start_and_end_minute_left ?? '' }}
                                                                {{ __('labels.Min') }}
                                                            </p>

                                                        </div>
                                                    </span>
                                                </li>
                                            </ul>

                                        </div>
                                        <ul class="list-unstyled mybarber_info mt-3 p-0">
                                            <li> <i><img
                                                        src="{{ static_asset('frontend/assets/images/calender.png') }}"></i><span>
                                                    <div class="mybarber_head">
                                                        <h6>{{ __('labels.Date & Time') }}</h6>
                                                    </div>
                                                </span></li>
                                        </ul>
                                        <p class="mt-0"> {{ date('d-M-Y', strtotime($booking->booking_date)) }},
                                            {{ date('h:i A', strtotime($booking->start_time)) }} -
                                            {{ date('h:i A', strtotime($booking->end_time)) }} </p>

                                        <ul class="list-unstyled mybarber_info mt-3 p-0">
                                            <li> <i><img
                                                        src="{{ static_asset('frontend/assets/images/scissors.png') }}"></i><span>
                                                    <div class="mybarber_head">
                                                        <h6>{{ __('labels.Service Selected') }}</h6>
                                                    </div>
                                                </span></li>
                                        </ul>


                                        @if (!empty($booking->booking_service_detailss))
                                            <div class="info2">
                                                @foreach ($booking->booking_service_detailss as $service)
                                                    <div class="mybarber_head">
                                                        <h6>{{ $service->main_service->$service_name }}</h6>
                                                    </div>
                                                    <p>{{ $service->sub_service->$service_name }}</p>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="mybarber_head mt-3">
                                            <h6>{{ $service->barber_detail->salon_name ?? '' }}</h6>
                                        </div>
                                        <?php /*
                                        <p>
                                            <i><img src="{{ static_asset('frontend/assets/images/loc-map.png') }}"></i>
                                            {{ $service->barber_detail->location ?? '' }} </span>
                                             </p>
                                             */
                                        ?>
                                        <div class="rating">
                                            <p><i><img src="{{ static_asset('frontend/assets/images/star-3.png') }}"></i>
                                                {{ $barber_data->average_rating }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($booking->process_status == 'finished')
                                    <div class="service-finished text-center">
                                        <img src="{{ static_asset('frontend/assets/images/verified-check.png') }}"
                                            class="img-fluid" alt="">
                                        <div class="info">
                                            <h2>{{ __('labels.Booking Finished') }}</h2>
                                            <p>We appreciate your feedback. Explore more services or contact support if you
                                                have any questions:</p>
                                        </div>

                                        <div class="rating mt-5">
                                            <h4>{{ __('labels.Rating') }}</h4>

                                            @if (!empty($booking->barber_reting))
                                                @php
                                                    $rating = $booking->barber_reting->rating ?? 0;
                                                @endphp


                                                <h2>{{ __('labels.Thanks for rating') }}</h2>
                                                <div id="full-stars-example">
                                                    <div class="rating-group">

                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fa fa-star icon {{ $i <= $rating ? 'checked' : '' }}"
                                                                aria-hidden="true"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            @else
                                                <form method="POST" action="{{ route('rating-submit') }}"
                                                    class="theme-form" id="rating_submit">
                                                    @csrf
                                                    <div id="full-stars-example">

                                                        <div class="rating-group">
                                                            <input type="hidden" name="barber_id"
                                                                value="{{ $booking->barber_id }}">
                                                            <input type="hidden" name="booking_id"
                                                                value="{{ $booking->id }}">
                                                            <label aria-label="1 star" class="rating__label"
                                                                for="rating-1"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating" id="rating-1"
                                                                value="1" type="radio">
                                                            <label aria-label="2 stars" class="rating__label"
                                                                for="rating-2"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating" id="rating-2"
                                                                value="2" type="radio">
                                                            <label aria-label="3 stars" class="rating__label"
                                                                for="rating-3"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating" id="rating-3"
                                                                value="3" type="radio" checked>
                                                            <label aria-label="4 stars" class="rating__label"
                                                                for="rating-4"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating" id="rating-4"
                                                                value="4" type="radio">
                                                            <label aria-label="5 stars" class="rating__label"
                                                                for="rating-5"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating" id="rating-5"
                                                                value="5" type="radio">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-success mx-2" id="rating_submit_button"
                                                        type="submit">{{ __('labels.Submit') }}</button>
                                                    <a href="{{ route('contact-us') }}"
                                                        class="btn btn-success">{{ __('labels.Contact-Support') }}</a>
                                        </div>
                                        </form>
                                @endif






                            @endif
                        </div>
                    @else
                        <!----cancel and reshedule booking---->

                        <!----- booking_type = waitlist ---->
                        <div class="mybarber_list">
                            <div class="user">
                                <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid"
                                    alt="user">
                            </div>
                            <div class="info">
                                <div class="mybarber_head">
                                    <h6>{{ $booking->barber_detail->first_name ?? '' }}
                                        {{ $booking->barber_detail->last_name ?? '' }}</h6>
                                </div>

                                <h4 class="view-title">{{ __('labels.Status') }} :
                                    @if ($booking->status == 'pending')
                                        {{ __('labels.Pending') }}
                                    @elseif ($booking->status == 'cancel')
                                        {{ __('labels.Cancel') }}
                                    @elseif($booking->status == 'reject')
                                        {{ __('labels.Reject') }}
                                    @elseif($booking->status == 'accept')
                                        {{ __('labels.Accept') }}
                                    @elseif($booking->status == 'finished')
                                        {{ __('labels.Finished') }}
                                    @elseif($booking->status == 'rescheduled')
                                        {{ __('labels.Rescheduled') }}
                                    @endif
                                </h4>
                                <p>{{ $booking->barber_detail->gender ?? '' }} </p>



                                <p class="date mb-0 text-warning"></p>
                                <div class="mybarber_head2">

                                    <div class="row image_upload">
                                        <div class="col-6 col-sm-12 col-md-6">
                                            <div class="detail-icon">
                                                <img src="{{ static_asset('frontend/assets/images/map.png') }}"
                                                    alt="">
                                                <br>
                                                <a href="https://www.google.com/maps?q={{ $booking->barber_detail->latitude }},{{ $booking->barber_detail->longitude }}"
                                                    target="_blank">
                                                    {{ $booking->barber_detail->location ?? '' }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-12 col-md-6">
                                            <div class="detail-icon">
                                                <a href="{{ route('my-chat') }}"><img
                                                        src="{{ static_asset('frontend/assets/images/chat.png') }}"
                                                        alt="">
                                                    <p>{{ __('labels.Chat') }} </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>






                                </div>
                            </div>

                            @if ($booking->booking_type == 'waitlist')

                                <ul class="list-unstyled mybarber_info mt-3 p-0">
                                    <li> <i><img
                                                src="{{ static_asset('frontend/assets/images/scissors.png') }}"></i><span>
                                            <div class="mybarber_head">
                                                <h6>{{ __('labels.My Preferences') }}</h6>
                                            </div>
                                        </span></li>
                                </ul>

                                <div class="info2">


                                    @if ($booking->customer_prefrences)
                                        @foreach ($booking->customer_prefrences as $prefrences)
                                            <div class="mybarber_head">
                                                @if ($prefrences->any_date == 1)
                                                    <p> {{ __('labels.Any Date') }}</p>
                                                @endif
                                                @if ($prefrences->any_date == 0)
                                                    <p> {{ $prefrences->selected_date }}</p>
                                                @endif
                                                @if ($prefrences->any_time == 1)
                                                    <p> {{ __('labels.Any Time') }}</p>
                                                @endif
                                                @if ($prefrences->any_time == 0)
                                                    <p> {{ $prefrences->from_time }} - {{ $prefrences->to_time }} </p>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>


                                <ul class="list-unstyled mybarber_info mt-3 p-0">
                                    <li> <i><img
                                                src="{{ static_asset('frontend/assets/images/scissors.png') }}"></i><span>
                                            <div class="mybarber_head">
                                                <h6>{{ __('labels.Barber Suggested Date and Time') }}</h6>
                                            </div>
                                        </span></li>
                                </ul>
                                <div class="info2">


                                    @if ($booking->booking_type == 'waitlist')

                                        @if ($booking->barber_proposal != '')
                                            @if ($booking->barber_proposal->status != 'reject')
                                                <div class="mybarber_head">
                                                    <h4>{{ __('labels.Barber Suggested Date and Time') }}</h4>
                                                    <p> {{ __('labels.Date') }} :
                                                        {{ $booking->barber_proposal->booking_date }} </p>
                                                    <p>{{ __('labels.Time') }} :
                                                        @foreach ($booking->barber_proposal->slots as $slots)
                                                            <p>{{ $slots }}</p>
                                                        @endforeach
                                                </div>

                                                <hr>
                                                <a href="javascript:void(0)"
                                                    data-url="{{ route('accept-barber-proposal', $booking->barber_proposal->id) }}"
                                                    class="btn text-white" id="accept_barber_proposal">
                                                    <span class="button_label_completed">
                                                        {{ __('labels.Accept') }}</span>
                                                </a>

                                                <a href="javascript:void(0)"
                                                    data-url="{{ route('reject-barber-proposal', $booking->barber_proposal->id) }}"
                                                    class="btn text-white" id="reject_barber_proposal">
                                                    <span class="button_label_cancel_booking">
                                                        {{ __('labels.Reject') }}</span>
                                                </a>
                                            @else
                                                <p>{{ __('labels.Barber Proposal Reject') }}</p>
                                            @endif
                                        @else
                                            <p>{{ __('labels.Wait for barber proposal') }}</p>
                                        @endif
                                    @endif
                                </div>

                            @endif

                            {{-- <ul class="list-unstyled mybarber_info mt-3 p-0">
                                <li> <i><img src="{{ static_asset('frontend/assets/images/calender.png') }}"></i><span>
                                        <div class="mybarber_head">
                                            <h6>{{ __('labels.Date & Time') }}</h6>
                                        </div>
                                    </span></li>
                            </ul>
                            <p class="mt-0">{{ date('d-M-Y', strtotime($booking->booking_date)) }},
                                {{ date('h:i A', strtotime($booking->start_time)) }} -  {{ date('h:i A', strtotime($booking->end_time)) }}</p> --}}

                            <ul class="list-unstyled mybarber_info mt-3 p-0">
                                <li> <i><img src="{{ static_asset('frontend/assets/images/scissors.png') }}"></i><span>
                                        <div class="mybarber_head">
                                            <h6>{{ __('labels.Service Selected') }}</h6>
                                        </div>
                                    </span></li>
                            </ul>

                            @if (!empty($booking->booking_service_detailss))
                                <div class="info2">
                                    @foreach ($booking->booking_service_detailss as $service)
                                        <div class="mybarber_head">
                                            <h6>{{ $service->main_service->$service_name }}</h6>
                                        </div>
                                        <p>{{ $service->sub_service->$service_name }}</p>
                                        <hr>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mybarber_head mt-3">
                                <h6>{{ $booking->barber_detail->salon_name ?? '' }}</h6>
                            </div>
                            <?php /*
                            <p>
                                <i><img src="{{ static_asset('frontend/assets/images/loc-map.png') }}"></i>
                                {{ $booking->barber_detail->location ?? '' }} </span>
                                 </p>
                                 */
                            ?>
                            <div class="rating">
                                <p><i><img src="{{ static_asset('frontend/assets/images/star-3.png') }}"></i>
                                    {{ $barber_data->average_rating }}
                                </p>
                            </div>
                        </div>
                        <!----- booking_type = waitlist ---->



                        @endif





                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


    <!-- Custom Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalLabel" aria-hidden="true">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('labels.No') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="confirmYesButton">{{ __('labels.Yes') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Custom Confirmation Modal -->
@endsection
@section('footer-script')
    <script>
        $(document).ready(function() {
            var actionUrl = '';
            var bookingId = '';

            function showModal(message, url) {
                $('#confirmationMessage').text(message);
                actionUrl = url;
                $('#confirmationModal').modal('show');
            }

            $('.cancel-booking').on('click', function(event) {
                event.preventDefault();
                bookingId = $(this).data('id');
                var message = "{{ __('message.Are you sure you want to cancel this booking?') }}";
                var url = "{{ route('cancel-booking', '') }}/" + bookingId;
                showModal(message, url);
            });

            $('.reschedule-booking').on('click', function(event) {
                event.preventDefault();
                bookingId = $(this).data('id');
                var message = "{{ __('message.Are you sure you want to reschedule this booking?') }}";
                var url = "{{ route('reschedule-booking', '') }}/" + bookingId;
                showModal(message, url);
            });

            $('#confirmYesButton').on('click', function() {
                window.location.href = actionUrl;
            });


            $("#rating_submit").submit(function(e) {
                e.preventDefault();

                var form_data = this;
                var formData = new FormData(form_data);
                var url = $(this).attr('action');
                var type = "POST";
                var submitButton = $(this).find("button[type='submit']");

                // Disable the button and add loader
                submitButton.prop('disabled', true).html(
                    '<i class="fa fa-spinner fa-spin"></i> Loading...');

                $.ajax({
                    type: type,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message);
                        form_data.reset();
                        window.setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        $(".error").removeClass('is-invalid');
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            $(ele).addClass('error is-invalid');
                            toastr.error(value);
                        });
                    },
                    complete: function() {
                        // Re-enable the button and remove loader
                        submitButton.prop('disabled', false).html('Submit');
                    }
                });
                return false;
            });



            $("#reject_barber_proposal").click(function(e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                var type = "GET";
                $.ajax({
                    type: type,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message);
                        window.setTimeout(function() {
                            // Move to a new location or you can do something else
                            location.reload();
                        }, 1000);

                    },
                })
                return false;
            });



            $("#accept_barber_proposal").click(function(e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                var type = "GET";
                $.ajax({
                    type: type,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message);
                        window.setTimeout(function() {
                            // Move to a new location or you can do something else
                            location.reload();
                        }, 1000);
                    },
                })
                return false;
            });









        });
    </script>
@endsection
