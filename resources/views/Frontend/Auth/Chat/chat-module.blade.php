@extends('Frontend.layouts.app')

@section('content')

    @php

        $auth = getauthdata();

        $language = config('app.locale');

        $title = 'title_' . $language;

        $name = 'page_name_' . $language;

        $subscription_name = 'subscription_name_' . $language;

        $subscription_detail = 'subscription_detail_' . $language;

        $profile_image = empty($auth->profile_image) ? 'default.png' : $auth->profile_image;

    @endphp



    <meta name="csrf-token" content="{{ csrf_token() }}">



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



    <section class="dashboard_sec colored-bg">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-3 col-md-6">

                    <div class="profile_sidebar">

                        <div class="sidebar_profile">

                            <img src="{{ static_asset('profile_image/' . $profile_image) }}" class="img-fluid"

                                alt="Profile Image">

                            <h3 class="name">{{ $auth->name ?? 'Demo User' }}</h3>

                            <hr>

                        </div>



                        <div class="sidebar_nav">

                            @include('Frontend.Auth.sidebar')

                        </div>

                    </div>

                </div>

                <div class="col-lg-9">

                    <div class="dashboard_right">

                        <div class="row align-items-center">

                            <div class="col-sm-12 col-md-12 col-lg-12">

                                <div class="heading_dashboard">

                                    <h3>{{ __('labels.Chat') }}</h3>

                                </div>

                            </div>

                        </div>                        

                        <div class="row no-gutters">

                            <div class="col-md-4">

                                <div class="search-box">
                                        <input placeholder="{{ __('labels.Search') }}" type="text" class="form-control" id="search_barber_name" name="search_barber_name">                                   
                                </div>

                                <div class="barberlist_chat">

                                    <!-- Dynamic barber list will be appended here -->

                                </div>

                            </div>

                            <div class="col-md-8 chat-container">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection



@section('footer-script')

    <script>

        $(document).ready(function() {

            // Call BarberList on page load with empty search

            var search = $("#search_barber_name").val();

            BarberList(search);





            // Add event listener for keyup on the search input

            $('#search_barber_name').on('keyup', function() {

                var search = $("#search_barber_name").val();

                BarberList(search);

            });



        });



        function BarberList(search) {

            $.ajax({

                type: "POST",

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                url: "{{ route('chat-list') }}",

                data: {

                    search: search

                },

                success: function(response) {

                    $(".barberlist_chat").html('');

                    $(".barberlist_chat").append(response);

                },

            });

        }

    </script>

@endsection

