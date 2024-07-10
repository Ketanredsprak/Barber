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
            <div class="row">

                <div class="col-sm-12 col-md-4 col-lg-3 left_sec">
                    <div class="col-sm-12">
                        <div class="mb-4">
                            {{-- <a href="" data-toggle="modal" data-target="#myModal3" class="filter_btn_mobile"> <img
                                    src="{{ static_asset('frontend/assets/images/filter.png') }}" class="img-fluid"
                                    alt="filter"> {{ __('labels.Filter') }}</a> --}}
                        </div>
                    </div>
                    <div class="filter-box filter_web">
                        <div class="widget">
                            <div class="widget-title">{{ __('labels.Barber Name') }}</div>
                            <div class="icon-input">
                                <input class="icon-input__text-field form-control" type="text" name="barber_name"
                                    id="barber_name">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>


                        <div class="widget">
                            <div class="widget-title">{{ __('labels.Salon Name') }}</div>
                            <div class="icon-input">
                                <input class="icon-input__text-field form-control" type="text" name="salon_name"
                                    id="salon_name">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>

                        <div class="widget">
                            <div class="widget-title">{{ __('labels.Service') }}</div>
                            <div class="form-group">
                                <select class="form-control" id="service_id" name="service_id">
                                    <option value="">{{ __('labels.Select Service') }}</option>"
                                    @foreach(getSubServices() as $service)
                                        <option value="{{ $service->id }}">{{ $service->$service_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="widget">
                            <div class="widget-title">{{ __('labels.Gender') }}</div>
                            <div class="dropdown-form">
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">{{ __('labels.Select Gender') }}</option>
                                    <option value="Male">{{ __('labels.Male') }}</option>
                                    <option value="Female">{{ __('labels.Female') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="widget">
                            <div class="widget-title">{{ __('labels.State Name') }}</div>
                            <div class="icon-input">
                                <input class="icon-input__text-field form-control" type="text" name="state_name"
                                    id="state_name">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>


                        <div class="widget">
                            <div class="widget-title">{{ __('labels.City Name') }}</div>
                            <div class="icon-input">
                                <input class="icon-input__text-field form-control" type="text" name="city_name"
                                    id="city_name">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <hr>
                        <div class="filter_btn pt-2">
                            <button class="btn btn-warning" type="submit" id="filterSubmit">{{ __('labels.Submit') }}</button>
                        </div>
                    </div>

                </div>



                <div class="col-sm-12 col-md-8 col-lg-9 right_sec barberList">

                </div>


            </div>
        </div>
        </div>
    </section>
@endsection


@section('footer-script')
    <script>
        $(document).ready(function() {
            var barber_name = '';
            var service_id = '';
            var gender = '';
            var salon_name = '';
            var state_name = '';
            var city_name = '';
            var page = 1;

            BarberList(barber_name, service_id, gender, salon_name, state_name, city_name, page);



            $("#filterSubmit").click(function() {
                var barber_name = $('#barber_name').val();
                var salon_name = $('#salon_name').val();
                var service_id = $('#service_id').val();
                var gender = $('#gender').val();
                var city_name = $('#city_name').val();
                var state_name = $('#state_name').val();
                var page = 1;

                BarberList(barber_name, service_id, gender, salon_name, state_name, city_name, page);
            });


            $('.barberList').on('click', '.pagination a', function(event) {
                event.preventDefault();
                page = $(this).attr('href').split('page=')[1];

                var barber_name = $('#barber_name').val();
                var salon_name = $('#salon_name').val();
                var service_id = $('#service_id').val();
                var gender = $('#gender').val();
                var city_name = $('#city_name').val();
                var state_name = $('#state_name').val();

                BarberList(barber_name, service_id, gender, salon_name, state_name, city_name, page);
            });
        });

        function BarberList(barber_name, service_id, gender, salon_name, state_name, city_name, page) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('barber-list-filter') }}?page=" + page,
                data: {
                    barber_name: barber_name,
                    service_id: service_id,
                    gender: gender,
                    salon_name: salon_name,
                    state_name: state_name,
                    city_name: city_name
                },
                success: function(response) {
                    $(".barberList").html('');
                    $(".barberList").append(response);
                },
                error: function(response) {
                    alert("error");
                }
            });
        }
    </script>
@endsection
