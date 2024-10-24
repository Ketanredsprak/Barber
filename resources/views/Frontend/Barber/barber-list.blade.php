@extends('Frontend.layouts.app')
@section('content')
    @php
        $language = config('app.locale');
        $title = 'title_' . $language;
        $sub_title = 'sub_title_' . $language;
        $content = 'content_' . $language;
        $name = 'page_name_' . $language;
        $service_name = 'service_name_' . $language;
        $serviceId = request()->query('service_id');
    @endphp
    <style>
        .form-check-input {
            width: auto;
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


    <section class="explore_sec colored-bg pt-75 pb-75">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="left_sec">
                        <div class="title">
                            <h3>Filter By</h3>
                        </div>
                        <div class="filter-box filter_web">
                            <div class="widget">
                                <div class="widget-title">{{ __('labels.Barber Name') }}</div>
                                <div class="icon-input">
                                    <input class="icon-input__text-field form-control" type="text" name="barber_name"
                                        id="barber_name" placeholder="{{ __('labels.Barber Name') }}">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>


                            <div class="widget">
                                <div class="widget-title">{{ __('labels.Salon Name') }}</div>
                                <div class="icon-input">
                                    <input class="icon-input__text-field form-control" type="text" name="salon_name"
                                        id="salon_name" placeholder="{{ __('labels.Salon Name') }}">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>

                            <div class="widget">
                                <div class="widget-title">{{ __('labels.Service') }}</div>
                                <div class="form-group">
                                    <select class="form-control custom-select" id="service_id" name="service_id">
                                        <option value="">{{ __('labels.Select Service') }}</option>"
                                        @foreach (getSubServices() as $service)
                                            <option value="{{ $service->id }}"
                                                @if ($serviceId != '') @if ($serviceId == $service->id) selected="" @endif
                                                @endif>{{ $service->$service_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="widget">
                                <div class="widget-title">{{ __('labels.Gender') }}</div>
                                <div class="dropdown-form">
                                    <select class="form-control custom-select" name="gender" id="gender">
                                        <option value="">{{ __('labels.Select Gender') }}</option>
                                        <option value="Male">{{ __('labels.Male') }}</option>
                                        <option value="Female">{{ __('labels.Female') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="widget">
                                <div class="widget-title">{{ __('labels.Region/State Name') }}</div>
                                <div class="icon-input">
                                    <input class="icon-input__text-field form-control" type="text" name="state_name"
                                        id="state_name" placeholder="{{ __('labels.Region/State Name') }}">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>


                            <div class="widget">
                                <div class="widget-title">{{ __('labels.City Name') }}</div>
                                <div class="icon-input">
                                    <input class="icon-input__text-field form-control" type="text" name="city_name"
                                        placeholder="{{ __('labels.City Name') }}" id="city_name">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>

                            <div class="widget range-wrapper">
                                <div class="widget-title">{{ __('labels.Your Budget (Per Service)') }}</div>
                                <div class="min-max-slider" data-legendnum="3">
                                    <!--     <label for="min">Minimum price</label> -->
                                    <input id="service_min_price" class="min" type="range" step="1"
                                        min="0" max="10000" name="service_min_price" />
                                    <!--     <label for="max">Maximum price</label> -->
                                    <input id="service_max_price" class="max" type="range" step="1"
                                        min="0" max="10000" name="service_max_price" />
                                </div>
                            </div>

                            <div class="widget range-wrapper mb-0">
                                <div class="widget-title">{{ __('labels.Average Rating') }}</div>
                                <div class="deals-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rating" type="radio" id="rating1" name="rating"
                                            value="1">
                                        <label class="form-check-label" for="rating1">{{ __('labels.1 Stars') }}</label>
                                    </div>
                                    <div>
                                        <small class="total-deals">{{ $ratingCounts[1] }}</small>
                                    </div>
                                </div>
                                <div class="deals-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rating" type="radio" id="rating2"
                                            name="rating" value="2">
                                        <label class="form-check-label" for="rating2">{{ __('labels.2 Stars') }}</label>
                                    </div>
                                    <div>
                                        <small class="total-deals">{{ $ratingCounts[2] }}</small>
                                    </div>
                                </div>
                                <div class="deals-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rating" type="radio" id="rating3"
                                            name="rating" value="3">
                                        <label class="form-check-label" for="rating3">{{ __('labels.3 Stars') }}</label>
                                    </div>
                                    <div>
                                        <small class="total-deals">{{ $ratingCounts[3] }}</small>
                                    </div>
                                </div>
                                <div class="deals-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rating" type="radio" id="rating4"
                                            name="rating" value="4">
                                        <label class="form-check-label" for="rating4">{{ __('labels.4 Stars') }}</label>
                                    </div>
                                    <div>
                                        <small class="total-deals">{{ $ratingCounts[4] }}</small>
                                    </div>
                                </div>
                                <div class="deals-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rating" type="radio" id="rating5"
                                            name="rating" value="5">
                                        <label class="form-check-label" for="rating5">{{ __('labels.5 Stars') }}</label>
                                    </div>
                                    <div>
                                        <small class="total-deals">{{ $ratingCounts[5] }}</small>
                                    </div>
                                </div>
                                <div class="deals-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input rating" type="radio" id="rating0"
                                            name="rating" value="0">
                                        <label class="form-check-label" for="rating0">{{ __('labels.Unrated') }}</label>
                                    </div>
                                    <div>
                                        <small class="total-deals">{{ $ratingCounts[0] }}</small>
                                    </div>
                                </div>
                            </div>



                            <script>
                                var thumbsize = 14;

                                function draw(slider, splitvalue) {

                                    /* set function vars */
                                    var min = slider.querySelector('.min');
                                    var max = slider.querySelector('.max');
                                    var lower = slider.querySelector('.lower');
                                    var upper = slider.querySelector('.upper');
                                    var legend = slider.querySelector('.legend');
                                    var thumbsize = parseInt(slider.getAttribute('data-thumbsize'));
                                    var rangewidth = parseInt(slider.getAttribute('data-rangewidth'));
                                    var rangemin = parseInt(slider.getAttribute('data-rangemin'));
                                    var rangemax = parseInt(slider.getAttribute('data-rangemax'));

                                    /* set min and max attributes */
                                    min.setAttribute('max', splitvalue);
                                    max.setAttribute('min', splitvalue);

                                    /* set css */
                                    min.style.width = parseInt(thumbsize + ((splitvalue - rangemin) / (rangemax - rangemin)) * (rangewidth - (2 *
                                        thumbsize))) + 'px';
                                    max.style.width = parseInt(thumbsize + ((rangemax - splitvalue) / (rangemax - rangemin)) * (rangewidth - (2 *
                                        thumbsize))) + 'px';
                                    min.style.left = '0px';
                                    max.style.left = parseInt(min.style.width) + 'px';
                                    min.style.top = lower.offsetHeight + 'px';
                                    max.style.top = lower.offsetHeight + 'px';
                                    legend.style.marginTop = min.offsetHeight + 'px';
                                    slider.style.height = (lower.offsetHeight + min.offsetHeight + legend.offsetHeight) + 'px';

                                    /* correct for 1 off at the end */
                                    if (max.value > (rangemax - 1)) max.setAttribute('data-value', rangemax);

                                    /* write value and labels */
                                    max.value = max.getAttribute('data-value');
                                    min.value = min.getAttribute('data-value');
                                    lower.innerHTML = min.getAttribute('data-value');
                                    upper.innerHTML = max.getAttribute('data-value');

                                }

                                function init(slider) {
                                    /* set function vars */
                                    var min = slider.querySelector('.min');
                                    var max = slider.querySelector('.max');
                                    var rangemin = parseInt(min.getAttribute('min'));
                                    var rangemax = parseInt(max.getAttribute('max'));
                                    var avgvalue = (rangemin + rangemax) / 2;
                                    var legendnum = slider.getAttribute('data-legendnum');

                                    /* set data-values */
                                    min.setAttribute('data-value', rangemin);
                                    max.setAttribute('data-value', rangemax);

                                    /* set data vars */
                                    slider.setAttribute('data-rangemin', rangemin);
                                    slider.setAttribute('data-rangemax', rangemax);
                                    slider.setAttribute('data-thumbsize', thumbsize);
                                    slider.setAttribute('data-rangewidth', slider.offsetWidth);

                                    /* write labels */
                                    var lower = document.createElement('span');
                                    var upper = document.createElement('span');
                                    lower.classList.add('lower', 'value');
                                    upper.classList.add('upper', 'value');
                                    lower.appendChild(document.createTextNode(rangemin));
                                    upper.appendChild(document.createTextNode(rangemax));
                                    slider.insertBefore(lower, min.previousElementSibling);
                                    slider.insertBefore(upper, min.previousElementSibling);

                                    /* write legend */
                                    var legend = document.createElement('div');
                                    legend.classList.add('legend');
                                    var legendvalues = [];
                                    for (var i = 0; i < legendnum; i++) {
                                        legendvalues[i] = document.createElement('div');
                                        var val = Math.round(rangemin + (i / (legendnum - 1)) * (rangemax - rangemin));
                                        legendvalues[i].appendChild(document.createTextNode(val));
                                        legend.appendChild(legendvalues[i]);

                                    }
                                    slider.appendChild(legend);

                                    /* draw */
                                    draw(slider, avgvalue);

                                    /* events */
                                    min.addEventListener("input", function() {
                                        update(min);
                                    });
                                    max.addEventListener("input", function() {
                                        update(max);
                                    });
                                }

                                function update(el) {
                                    /* set function vars */
                                    var slider = el.parentElement;
                                    var min = slider.querySelector('#service_min_price');
                                    var max = slider.querySelector('#service_max_price');
                                    var minvalue = Math.floor(min.value);
                                    var maxvalue = Math.floor(max.value);

                                    /* set inactive values before draw */
                                    min.setAttribute('data-value', minvalue);
                                    max.setAttribute('data-value', maxvalue);

                                    var avgvalue = (minvalue + maxvalue) / 2;

                                    /* draw */
                                    draw(slider, avgvalue);
                                }

                                var sliders = document.querySelectorAll('.min-max-slider');
                                sliders.forEach(function(slider) {
                                    init(slider);
                                });
                            </script>
                        </div>
                    </div>
                    <div class="filter_btn pt-2 content-center">
                        <button class="btn btn-warning" type="submit"
                            id="filterSubmit">{{ __('labels.Search') }}</button>
                        <button class="btn btn-light" type="submit" id="filterReset">{{ __('labels.Reset') }}</button>
                    </div>
                </div>


                <div class="filter-box filter_web">
                    <!-- Your existing filter code -->
                </div>


                <div
                    class="col-sm-12 col-md-8 col-lg-9 right_sec barberList d-flex justify-content-center align-items-center">
                    <img src="{{ static_asset('frontend/assets/images/loader.gif') }}" alt="Loading..." />
                </div>





            </div>
        </div>
        </div>
    </section>
@endsection


@section('footer-script')
    <script>
        $(document).ready(function() {
            var service_min_price = '';
            var service_max_price = '';
            var rating = '';
            var barber_name = '';
            var service_id = '';
            var gender = '';
            var salon_name = '';
            var state_name = '';
            var city_name = '';
            var page = 1;

            BarberList(service_min_price, service_max_price, rating, barber_name, service_id, gender, salon_name,
                state_name, city_name, page);


            $("#filterReset").click(function() {
                $('input[name="rating"]').prop('checked', false);
                $('#service_min_price').val('');
                $('#service_max_price').val('');
                $('#barber_name').val('');
                $('#salon_name').val('');
                $('#service_id').val('');
                $('#gender').val('');
                $('#city_name').val('');
                $('#state_name').val('');

                // Reset variables and reload the barber list
                service_min_price = '';
                service_max_price = '';
                rating = '';
                barber_name = '';
                salon_name = '';
                service_id = '';
                gender = '';
                city_name = '';
                state_name = '';
                page = 1;

                $("#loader").show();

                // Reload the barber list with reset filters
                BarberList(service_min_price, service_max_price, rating, barber_name, service_id, gender,
                    salon_name, state_name, city_name, page);
            });




            $("#filterSubmit").click(function() {
                var rating = $('input[name="rating"]:checked').val() || '';
                var service_min_price = $('#service_min_price').val();
                var service_max_price = $('#service_max_price').val();
                var barber_name = $('#barber_name').val();
                var salon_name = $('#salon_name').val();
                var service_id = $('#service_id').val();
                var gender = $('#gender').val();
                var city_name = $('#city_name').val();
                var state_name = $('#state_name').val();
                var page = 1;

                $("#loader").show();

                BarberList(service_min_price, service_max_price, rating, barber_name, service_id, gender,
                    salon_name, state_name, city_name, page);
            });


            $('.barberList').on('click', '.pagination a', function(event) {
                event.preventDefault();
                page = $(this).attr('href').split('page=')[1];
                var service_min_price = $('#service_min_price').val();
                var service_max_price = $('#service_max_price').val();
                var rating = $('#rating').val();
                var barber_name = $('#barber_name').val();
                var salon_name = $('#salon_name').val();
                var service_id = $('#service_id').val();
                var gender = $('#gender').val();
                var city_name = $('#city_name').val();
                var state_name = $('#state_name').val();

                $("#loader").show();

                BarberList(service_min_price, service_max_price, rating, barber_name, service_id, gender,
                    salon_name, state_name, city_name, page);
            });
        });

        function BarberList(service_min_price, service_max_price, rating, barber_name, service_id, gender, salon_name,
            state_name, city_name, page) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('barber-list-filter') }}?page=" + page,
                data: {
                    service_min_price: service_min_price,
                    service_max_price: service_max_price,
                    rating: rating,
                    barber_name: barber_name,
                    service_id: service_id,
                    gender: gender,
                    salon_name: salon_name,
                    state_name: state_name,
                    city_name: city_name
                },
                success: function(response) {
                    $("#loader").hide();
                    $(".barberList").removeClass('d-flex');
                    $(".barberList").removeClass('justify-content-center');
                    $(".barberList").removeClass('align-items-center');
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
