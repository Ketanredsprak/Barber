@extends('Frontend.layouts.app')
@section('content')
    @php
        $language = config('app.locale');
        $title = 'title_' . $language;
        $sub_title = 'sub_title_' . $language;
        $content = 'content_' . $language;
        $name = 'page_name_' . $language;
        $service_name = 'service_name_' . $language;
        $today = now()->format('Y-m-d');
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
            <div class="text-left">
                <div class="title">
                    <h2>{{ $data->cms_content[0]->$title }}</h2>
                    <p>{{ $data->cms_content[0]->$sub_title }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('join-waitlist') }}" class="theme-form" id="join_wait_list_form">
                @csrf

                <input type="hidden" class="form-control" name="booking_id" id="booking_id"
                    value="{{ $booking_detail->id }}">

                <div class="waitlist-title">
                    <h5>{{ __('labels.Availability preference') }}</h5>
                </div>

                <div class="whitebox">
                    <p class="waitlist-info">
                        <img src="{{ static_asset('frontend/assets/images/waitlist-calender.png') }}">
                        <span>{{ __('labels.Select Date and Time') }}</span>
                    </p>
                    <hr>
                    <div class="date">
                        <h5>{{ __('labels.Date') }}</h5>
                    </div>

                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="any_date_button"><input type="radio"
                                class="hidden" name="any_date[]" id="any_date" checked value="1" />
                            {{ __('labels.Any Date') }} </button>
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_date_button"><input type="radio"
                                class="hidden" name="select_date[]" id="select_date" value="1" />
                            {{ __('labels.Select Date') }} </button>
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_date_range_button"><input
                                type="radio" class="hidden" name="select_date_range[]" id="select_date_range"
                                value="1" /> {{ __('labels.Select Date Range') }}</button>
                    </span>

                    <div class="row d-none" id="select_date_section">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="{{ __('labels.Select Date') }}"
                                    name="selected_date[]" id="select_date" min="{{ $today }}" >
                            </div>
                        </div>
                    </div>

                    <div class="row d-none" id="date_range_section">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="{{ __('labels.From Date') }}"
                                    name="from_date[]" id="from_date" min="{{ $today }}" >
                            </div>
                        </div>
                        <div class="col-xs-1 dash">
                            <p>&mdash;</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="{{ __('labels.To Date') }}"
                                    name="to_date[]" id="to_date" min="{{ $today }}" >
                            </div>
                        </div>
                    </div>

                    <div class="date">
                        <h5>{{ __('labels.Time') }}</h5>
                    </div>

                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="any_time_button"><input type="radio"
                                class="hidden" name="any_time[]" id="any_time" checked value="1" />
                            {{ __('labels.Any Time') }} </button>
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_time_button"><input type="radio"
                                class="hidden" name="select_time[]" id="select_time" value="1" />
                            {{ __('labels.Select Time') }} </button>
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_time_range_button"><input
                                type="radio" class="hidden" name="select_time_range[]" id="select_time_range"
                                value="1" /> {{ __('labels.Select Time Range') }}</button>
                    </span>

                    <div class="row d-none" id="select_time_section">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="time" class="form-control" placeholder="{{ __('labels.Select Time') }}"
                                    name="selected_time[]" id="select_time" >
                            </div>
                        </div>
                    </div>

                    <div class="row d-none" id="time_range_section">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="time" class="form-control" placeholder="{{ __('labels.From Time') }}"
                                    name="from_time[]" id="from_time" >
                            </div>
                        </div>
                        <div class="col-xs-1 dash">
                            <p>&mdash;</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="time" class="form-control" placeholder="{{ __('labels.To Time') }}"
                                    name="to_time[]" id="to_time" >
                            </div>
                        </div>
                    </div>

                    <div class="date ml-3 d-none" id="add_preference">
                        <h5 id="add_more_preference">
                            <labels>{{ __('labels.Add Preferences') }}</labels>
                        </h5>
                    </div>

                    <div id="div_add_more_preference"></div>

                    <div class="service-edit">
                        <h5>{{ __('labels.Services') }}</h5>
                        <a href="{{ route('get-booking-page', $barber_id) }}">{{ __('labels.Edit') }}</a>
                    </div>

                    @foreach ($booking_detail->booking_service_detailss as $service)
                        <div class="whitebox">
                            <div class="waitlist_info">
                                <h5>{{ $service->main_service->$service_name }}</h5>
                                <p>{{ $service->sub_service->$service_name }}</p>
                                <p class="time">{{ __('labels.30 min') }}</p>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success btn-block mt-3 mb-3"
                    id="join_waitlist">{{ __('labels.Book Waitlist') }}</button>
            </form>

            <div class="whitebox">
                <p class="instruction">{{ $data->cms_content[0]->$content }}</p>
            </div>
        </div>
    </section>
@endsection

@section('footer-script')
    <script>
        $(document).ready(function() {
            var i = 1;

            // Set default state
            $("#any_date").prop("checked", true);
            $("#any_time").prop("checked", true);
            $("#select_date_section").addClass("d-none");
            $("#date_range_section").addClass("d-none");
            $("#select_time_section").addClass("d-none");
            $("#time_range_section").addClass("d-none");
            $("#add_preference").addClass("d-none");

            // Toggle date sections
            $("#any_date_button").click(function() {
                $("#select_date_section").addClass("d-none");
                $("#date_range_section").addClass("d-none");
                $("#any_date").prop("checked", true);
                $("#select_date").prop("checked", false);
                $("#select_date_range").prop("checked", false);
                updateAddPreferenceVisibility();
                clearPreferences();
            });

            $("#select_date_button").click(function() {
                $("#select_date_section").removeClass("d-none");
                $("#date_range_section").addClass("d-none");
                $("#select_date").prop("checked", true);
                $("#any_date").prop("checked", false);
                $("#select_date_range").prop("checked", false);
                updateAddPreferenceVisibility();
            });

            $("#select_date_range_button").click(function() {
                $("#select_date_section").addClass("d-none");
                $("#date_range_section").removeClass("d-none");
                $("#select_date_range").prop("checked", true);
                $("#any_date").prop("checked", false);
                $("#select_date").prop("checked", false);
                updateAddPreferenceVisibility();
            });

            // Toggle time sections
            $("#any_time_button").click(function() {
                $("#select_time_section").addClass("d-none");
                $("#time_range_section").addClass("d-none");
                $("#any_time").prop("checked", true);
                $("#select_time").prop("checked", false);
                $("#select_time_range").prop("checked", false);
                updateAddPreferenceVisibility();
                clearPreferences();
            });

            $("#select_time_button").click(function() {
                $("#select_time_section").removeClass("d-none");
                $("#time_range_section").addClass("d-none");
                $("#select_time").prop("checked", true);
                $("#any_time").prop("checked", false);
                $("#select_time_range").prop("checked", false);
                updateAddPreferenceVisibility();
            });

            $("#select_time_range_button").click(function() {
                $("#select_time_section").addClass("d-none");
                $("#time_range_section").removeClass("d-none");
                $("#select_time_range").prop("checked", true);
                $("#any_time").prop("checked", false);
                $("#select_time").prop("checked", false);
                updateAddPreferenceVisibility();
            });

            function updateAddPreferenceVisibility() {
                if ($("#any_date").is(":checked") && $("#any_time").is(":checked")) {
                    $("#add_preference").addClass("d-none");
                } else {
                    $("#add_preference").removeClass("d-none");
                }
            }

            function clearPreferences() {
                $("#div_add_more_preference").empty();
            }

            // Add more preferences
            $("#add_preference").click(function() {
                var html = '';
                html +=`<div id="preference_${i}">`;
                html +=`<hr>`;
                html +=`<div class="date"><h5>{{ __('labels.Date') }}</h5></div>`;
                html +=`<span class="button-radio"><button type="button" class="btn btn-light mb-3" id="any_date_button_${i}"><input type="radio" class="hidden" name="any_date[${i}]" id="any_date_${i}" checked value="1" />{{ __('labels.Any Date') }}</button></span>`;
                html +=`<span class="button-radio"><button type="button" class="btn btn-light mb-3" id="select_date_button_${i}"><input type="radio" class="hidden" name="select_date[${i}]" id="select_date_${i}" value="1" />{{ __('labels.Select Date') }}</button></span>`;
                html +=`<span class="button-radio"><button type="button" class="btn btn-light mb-3" id="select_date_range_button_${i}"><input type="radio" class="hidden" name="select_date_range[${i}]" id="select_date_range_${i}" value="1" />{{ __('labels.Select Date Range') }}</button></span>`;
                html +=`<div class="row d-none" id="select_date_section_${i}"><div class="col-sm-4"><div class="form-group"><input type="date" class="form-control" placeholder="{{ __('labels.Select Date') }}" name="selected_date[${i}]" id="select_date_${i}" min="{{ $today }}" ></div></div></div>`;
                html +=`<div class="row d-none" id="date_range_section_${i}"><div class="col-sm-4"><div class="form-group"><input type="date" class="form-control" placeholder="{{ __('labels.From Date') }}" name="from_date[${i}]" id="from_date_${i}" min="{{ $today }}" ></div></div><div class="col-xs-1 dash"><p>&mdash;</p></div><div class="col-sm-4"><div class="form-group"><input type="date" class="form-control" placeholder="{{ __('labels.To Date') }}" name="to_date[${i}]" id="to_date_${i}" min="{{ $today }}" ></div></div></div>`;
                html +=`<div class="date"><h5>{{ __('labels.Time') }}</h5></div>`;
                html +=`<span class="button-radio"><button type="button" class="btn btn-light mb-3" id="any_time_button_${i}"><input type="radio" class="hidden" name="any_time[${i}]" id="any_time_${i}" checked value="1" />{{ __('labels.Any Time') }}</button></span>`;
                html +=`<span class="button-radio"><button type="button" class="btn btn-light mb-3" id="select_time_button_${i}"><input type="radio" class="hidden" name="select_time[${i}]" id="select_time_${i}" value="1" />{{ __('labels.Select Time') }}</button></span>`;
                html +=`<span class="button-radio"><button type="button" class="btn btn-light mb-3" id="select_time_range_button_${i}"><input type="radio" class="hidden" name="select_time_range[${i}]" id="select_time_range_${i}" value="1" />{{ __('labels.Select Time Range') }}</button></span>`;
                html +=`<button type="button" class="btn btn-sm remove-preference"><i class="fa fa-trash" aria-hidden="true"></i></button>`;
                html +=`<div class="row d-none" id="select_time_section_${i}"><div class="col-sm-4"><div class="form-group"><input type="time" class="form-control" placeholder="{{ __('labels.Select Time') }}" name="selected_time[${i}]" id="select_time_${i}" ></div></div></div>`;
                html +=`<div class="row d-none" id="time_range_section_${i}"><div class="col-sm-4"><div class="form-group"><input type="time" class="form-control" placeholder="{{ __('labels.From Time') }}" name="from_time[${i}]" id="from_time_${i}" ></div></div><div class="col-xs-1 dash"><p>&mdash;</p></div><div class="col-sm-4"><div class="form-group"><input type="time" class="form-control" placeholder="{{ __('labels.To Time') }}" name="to_time[${i}]" id="to_time_${i}" ></div></div></div>`;
                html +=`</div>`;
                $("#div_add_more_preference").append(html);
                i++;

                // Add event listeners for newly added preferences
                addPreferenceEventListeners(i - 1);
            });


            $(document).on('click', '.remove-preference', function() {
                $(this).closest('div[id^="preference_"]').remove();
            });

            // Add event listeners for dynamically added preferences
            function addPreferenceEventListeners(index) {
                $(`#any_date_button_${index}`).click(function() {
                    $(`#select_date_section_${index}`).addClass("d-none");
                    $(`#date_range_section_${index}`).addClass("d-none");
                    $(`#any_date_${index}`).prop("checked", true);
                    $(`#select_date_${index}`).prop("checked", false);
                    $(`#select_date_range_${index}`).prop("checked", false);
                    updateAddPreferenceVisibility();
                });

                $(`#select_date_button_${index}`).click(function() {
                    $(`#select_date_section_${index}`).removeClass("d-none");
                    $(`#date_range_section_${index}`).addClass("d-none");
                    $(`#select_date_${index}`).prop("checked", true);
                    $(`#any_date_${index}`).prop("checked", false);
                    $(`#select_date_range_${index}`).prop("checked", false);
                    updateAddPreferenceVisibility();
                });

                $(`#select_date_range_button_${index}`).click(function() {
                    $(`#select_date_section_${index}`).addClass("d-none");
                    $(`#date_range_section_${index}`).removeClass("d-none");
                    $(`#select_date_range_${index}`).prop("checked", true);
                    $(`#any_date_${index}`).prop("checked", false);
                    $(`#select_date_${index}`).prop("checked", false);
                    updateAddPreferenceVisibility();
                });

                $(`#any_time_button_${index}`).click(function() {
                    $(`#select_time_section_${index}`).addClass("d-none");
                    $(`#time_range_section_${index}`).addClass("d-none");
                    $(`#any_time_${index}`).prop("checked", true);
                    $(`#select_time_${index}`).prop("checked", false);
                    $(`#select_time_range_${index}`).prop("checked", false);
                    updateAddPreferenceVisibility();
                });

                $(`#select_time_button_${index}`).click(function() {
                    $(`#select_time_section_${index}`).removeClass("d-none");
                    $(`#time_range_section_${index}`).addClass("d-none");
                    $(`#select_time_${index}`).prop("checked", true);
                    $(`#any_time_${index}`).prop("checked", false);
                    $(`#select_time_range_${index}`).prop("checked", false);
                    updateAddPreferenceVisibility();
                });

                $(`#select_time_range_button_${index}`).click(function() {
                    $(`#select_time_section_${index}`).addClass("d-none");
                    $(`#time_range_section_${index}`).removeClass("d-none");
                    $(`#select_time_range_${index}`).prop("checked", true);
                    $(`#any_time_${index}`).prop("checked", false);
                    $(`#select_time_${index}`).prop("checked", false);
                    updateAddPreferenceVisibility();
                });
            }
        });


        $("#join_wait_list_form").submit(function(e) {
            e.preventDefault();

            var form_data = this;
            var formData = new FormData(form_data);
            var url = $(this).attr('action');
            var type = "POST";

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
                        var url = "{{ route('my-booking-appointment-today') }}";
                        window.location.href = url;
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
                }
            });
            return false;
        });
    </script>
@endsection
