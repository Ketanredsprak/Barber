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
                            <div class="wrapper">
                                <ul class="nav nav-tabs addpost_tab" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="my-booking-appointments-tab"
                                            href="{{ route('my-booking-appointment-today') }}">{{ __('labels.Appointments') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="history-tab"
                                            href="{{ route('my-booking-appointment-history') }}">{{ __('labels.History') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="my-booking-appointments" role="tabpanel"
                                        aria-labelledby="my-booking-appointments-tab">


                                        @foreach ($Today_Appointments as $today_app)
                                            <?php

                                            if (empty($today_app->barber_detail->profile_image)) {
                                                $profile_image = 'default.png';
                                            } else {
                                                $profile_image = $today_app->barber_detail->profile_image;
                                            }
                                            ?>

                                            <div class="row align-items-center pb-35 ">
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="post_img">

                                                                <img src="{{ static_asset('profile_image/' . $profile_image) }}"
                                                                    class="img-fluid" alt="my post">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="post_info">

                                                                @if($today_app->booking_type == "booking")
                                                                    <p class="date">
                                                                        {{ date('d-M-Y', strtotime($today_app->booking_date)) }}
                                                                        -
                                                                        {{ date('h:i A', strtotime($today_app->start_time)) }}
                                                                    </p>
                                                                @else
                                                                     <p>{{ __('labels.Wait for barber proposal')}}</p>
                                                                @endif

                                                                <a href="javascript:void(0)" class="view-data"
                                                                    data-url="{{ route('my-booking-appointment-detail', $today_app->id) }}">
                                                                    <h5>{{ $today_app->barber_detail->first_name }}
                                                                        {{ $today_app->barber_detail->last_name }}</h5>
                                                                </a>

                                                                <a href="javascript:void(0)" class="view-data"
                                                                    data-url="{{ route('my-booking-appointment-detail', $today_app->id) }}">
                                                                    <h4 class="shop_name2">
                                                                        {{ $today_app->barber_detail->salon_name }}</h4>
                                                                </a>

                                                                <ul class="list-unstyled available_info mt-3 p-0">
                                                                    <li><i><img
                                                                                src="{{ static_asset('frontend/assets/images/location.png') }}"></i><span>{{ $today_app->barber_detail->location }}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">

                                                    <a href="{{ route('get-booking-detail', $today_app->id) }}">



                                                        @if ($today_app->status == 'pending')
                                                            <span class="button_label_today">
                                                                {{ __('labels.Pending') }}</span>
                                                        @elseif ($today_app->status == 'cancel')
                                                            <span class="button_label_cancel_booking">
                                                                {{ __('labels.Cancel') }}</span>
                                                        @elseif($today_app->status == 'reject')
                                                            <span class="button_label_reject_reject">
                                                                {{ __('labels.Reject') }} </span>
                                                        @elseif($today_app->status == 'accept')
                                                            <span class="button_label_completed">
                                                                {{ __('labels.Accept') }}
                                                            </span>
                                                        @elseif($today_app->status == 'finished')
                                                            <span class="button_label_completed">
                                                                {{ __('labels.Finished') }} </span>
                                                        @elseif($today_app->status == 'rescheduled')
                                                            <span class="button_label_rescheduled">
                                                                {{ __('labels.Rescheduled') }} </span>
                                                        @endif

                                                    </a>


                                                    <a href="{{ route('get-booking-detail', $today_app->id) }}">

                                                        <br>
                                                        @if ($today_app->booking_type == 'booking')
                                                            <span class="button_label_today">
                                                                {{ __('labels.Booking') }}</span>
                                                        @elseif($today_app->booking_type == 'waitlist')
                                                            <span class="button_label_rescheduled">
                                                                {{ __('labels.Waitlist') }} </span>
                                                        @endif

                                                    </a>




                                                </div>



                                            </div>


                                            <hr>
                                        @endforeach


                                        {!! $Today_Appointments->links() !!}


                                        <!-- Add more appointments similarly -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- show model --->
    <div class="modal right fade" id="showdetailModel" tabindex="-1" role="dialog" aria-labelledby="showdetailModel">
    </div>
    <!-- show model end --->
@endsection


@section('footer-script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {

            (function() {
                history.pushState(null, null, location.href);
                window.onpopstate = function() {
                    history.go(1);
                };
            })();


            @if (session('status'))
                toastr.success("{{ session('status') }}");
            @endif


            $(".view-data").click(function(e) {

                e.preventDefault();


                var url = $(this).attr('data-url');
                var type = "Get";
                $.ajax({
                    type: type,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#showdetailModel').html(response);
                        $('#showdetailModel').modal('show');
                    },
                })
                return false;

            });
        })
    </script>
@endsection
