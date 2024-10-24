@extends('Frontend.layouts.app')

@section('content')

    @php

        $auth = getauthdata();

        $language = config('app.locale');

        $title = 'title_' . $language;

        $name = 'page_name_' . $language;

        $subscription_name = 'subscription_name_' . $language;

        $subscription_detail = 'subscription_detail_' . $language;

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





    <section class="dashboard_sec colored-bg">

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

                                    <h3>{{ __('labels.My Package') }}</h3>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            {{-- <div class="col-lg-6">

                                <div class="package_box2">

                                    <div class="info">

                                        <h4>Silver</h4>

                                        <p class="mb-3">Lorem Ipsum is simply

                                            dummy text of the</p>

                                        <h4>$ 28.99</h4>

                                        <button class="btn btn-warning mt-4" type="submit">Update</button>

                                    </div>

                                </div>

                            </div> --}}

                            {{-- dd($data['subscription_data']); --}}

                            @php

                                $current_subscription_id = $data->current_subscription->subscription_id ?? 0;


                            @endphp

                            @foreach ($data['subscription_data'] as $subscription)


                                @php

                                    if ($current_subscription_id != $subscription->id) {

                                        $class_name = 'package_box';
                                        $text = 'best offer';

                                    } else {

                                        $class_name = 'package_box';
                                        $text = 'active';

                                    }

                                @endphp



                                <div class="col-lg-6">

                                    <div class="{{ $class_name }}">

                                        <div class="info">
                                            <h6 class="best-offer">{{ $text }}</h6>
                                            <h4>{{ $subscription->$subscription_name }}</h4>

                                            @php $detail = getFirstTenWords($subscription->$subscription_detail) @endphp

                                            <p>

                                                {{ @$detail }}

                                            </p>

                                            <h5>{{ __('labels.Booking') }} : {{ $subscription->number_of_booking }}</h5>

                                            <h5>{{ __('labels.Price') }} : {{ $subscription->price == 0 ? __('labels.Free') : '$' . $subscription->price }} </h5>

                                            @if($subscription->duration_in_days > 0)

                                            <h5>{{ __('labels.Duration') }} : {{ $subscription->duration_in_days }} </h5>

                                            @endif



                                            @if ($current_subscription_id != $subscription->id)

                                                <a class="btn btn-success mt-4" href="{{ route('update-package',$subscription->encrypt_id) }}"

                                                    type="submit">{{ __('labels.Upgrade') }}</a>

                                            @endif





                                        </div>

                                    </div>

                                </div>

                            @endforeach







                        </div>

                    </div>

                </div>



            </div>

        </div>

    </section>

@endsection

