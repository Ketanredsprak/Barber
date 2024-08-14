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
                                        <a class="nav-link" id="my-booking-appointments-tab"
                                            href="{{ route('my-booking-appointment-today') }}">{{ __('labels.Appointments') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="history-tab"
                                            href="{{ route('my-booking-appointment-history') }}">{{ __('labels.History') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade  show active" id="history" role="tabpanel"
                                        aria-labelledby="history-tab">
                                        @foreach ($Old_Appointments as $old_app)
                                            <?php
                                            if (empty($old_app->barber_detail->profile_image)) {
                                                $profile_image = 'default.png';
                                            } else {
                                                $profile_image = $old_app->barber_detail->profile_image;
                                            }
                                            ?>

                                                <div class="row align-items-center pb-35">
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
                                                                    <p class="date">{{  date('d-M-Y', strtotime($old_app->booking_date)) }} - {{  date('h:i A', strtotime($old_app->start_time)) }}</p>

                                                                    <a href="javascript:void(0)" class="view-data"
                                                                    data-url="{{ route('my-booking-appointment-detail', $old_app->id) }}"><h5>{{ $old_app->barber_detail->first_name }}
                                                                        {{ $old_app->barber_detail->last_name }}</h5> </a>


                                                                    <a href="javascript:void(0)" class="view-data"
                                                                        data-url="{{ route('my-booking-appointment-detail', $old_app->id) }}"><h4 class="shop_name2">
                                                                        {{ $old_app->barber_detail->salon_name }}</h4> </a>

                                                                    <ul class="list-unstyled available_info mt-3 p-0">
                                                                        <li><i><img
                                                                                    src="{{ static_asset('frontend/assets/images/location.png') }}"></i><span>{{ $old_app->barber_detail->location }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <a href="{{ route('get-booking-detail', $old_app->id) }}"> <span  class="button_label_completed">{{ __('labels.Complete') }}</span> </a>
                                                    </div>
                                                </div>

                                            <hr>
                                        @endforeach
                                       {!! $Old_Appointments->links() !!}
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
    <div class="modal right fade" id="viewbookingmodel" tabindex="-1" role="dialog" aria-labelledby="viewbookingmodel">
    </div>
    <!-- show model end --->

@endsection


@section('footer-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
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

                        $('#viewbookingmodel').html(response);
                        $('#viewbookingmodel').modal('show');

                    },
                })
                return false;

            });
        })
    </script>
@endsection
