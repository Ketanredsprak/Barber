@extends('Frontend.layouts.app')
@section('content')

    @php
        $language = config('app.locale');
        $title = 'title_' . $language;
        $sub_title = 'sub_title_' . $language;
        $content = 'content_' . $language;
        $name = 'page_name_' . $language;
        $service_name = 'service_name_' . $language;
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

    <section class="explore_sec pt-75 pb-75">
        <div class="container">



            <div class="whitebox">
                <div class="service-finished text-center">
                    <img src="{{ static_asset('frontend/assets/images/verified-check.png') }}" class="img-fluid" alt="">
                    <div class="info">
                        <h2>{{ $data->cms_content[0]->$title }}</h2>
                        <p>{{ $data->cms_content[0]->$content }} </p>
                    </div>
                </div>
                <div class="whitebox">
                    <div class="payment_summery pt-3">
                        <h4 class="view-title">{{ $data->booking->barber_detail->salon_name }} </h4>
                        <div class="d-flex justify-content-between mb-4 ">
                            <span>{{ $data->booking->barber_detail->location }}</span> <span
                                class="date">{{ date('d-M-Y', strtotime($data->booking->booking_date)) }}
                                {{ date('h:i A', strtotime($data->booking->start_time)) }} - {{ date('h:i A', strtotime($data->booking->end_time)) }}</span>
                        </div>

                        <h4 class="view-title"> {{ __('labels.Payment summary (Paid at salon)') }} </h4>

                        @if ($data->booking->booking_service_detailss)
                            @foreach ($data->booking->booking_service_detailss as $service)
                                <div class="d-flex justify-content-between mb-1 ">
                                    <span>{{ $service->$service_name }}</span> <span>${{ $service->price }}.00</span>
                                </div>
                            @endforeach
                        @endif

                        <hr>
                        <div class="d-flex justify-content-between mb-4 ">
                            <span>{{ __('labels.Total Price') }}</span> <strong
                                class="text-dark">${{ $data->booking->total_price }}.00</strong>
                        </div>

                    </div>
                    <a href="{{ route('my-booking-appointment-today') }}" class="btn btn-success"
                        type="submit">{{ __('labels.My Booking') }}</a>
                    <button class="btn btn-outline-success" type="submit">{{ __('labels.Download') }}</button>

                </div>

            </div>


        </div>
        </div>

    </section>
@endsection
@section('footer-script')
<script>
    (function() {
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    })();
</script>
@endsection
