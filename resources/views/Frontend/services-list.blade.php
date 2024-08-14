@extends('Frontend.layouts.app')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN7PVmJtnKlsH164uR42PvclqQyUCqOXE&libraries=places">
</script>


@section('content')
    @php
        $language = config('app.locale');
        $title = 'title_' . $language;
        $sub_title = 'sub_title_' . $language;
        $content = 'content_' . $language;
        $testimonial_content = 'testimonial_content_' . $language;
        $name = 'page_name_' . $language;
        $service_name = 'service_name_' . $language;
        $designation = 'designation_' . $language;
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


            <div class="row">

                @if ($services->isEmpty())
                    <div class="white-box">
                        <div class="col-sm-12">

                            <div class="no-record">
                                <img src="{{ static_asset('frontend/assets/images/no-record.png') }}" class="img-fluid">
                            </div>

                        </div>
                    </div>
                @else
                    @foreach ($services as $service)
                        <div class="col-sm-4">
                            <div class="explore_box">
                                <img src="{{ static_asset('service_image/' . $service->service_image) }}" class="img-fluid"
                                    alt="explore">
                                <div class="info">
                                    <a href="{{ route('barber-list')}}">
                                        <h4 class="text-center">({{ $service->parent->$service_name }}){{ $service->$service_name }}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>


            <div class="row">
                <div class="col-sm-12 mt-5">
                    {!! $services->links() !!}
                </div>
            </div>


        </div>
    </section>


@endsection
