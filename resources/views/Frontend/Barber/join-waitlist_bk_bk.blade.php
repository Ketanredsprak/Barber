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
            <div class="text-left">
                <div class="title">
                    <h2>{{ $data->cms_content[0]->$title }}</h2>
                    <p>{{ $data->cms_content[0]->$sub_title }}</p>
                </div>
            </div>

            <form method="POST" action="" class="theme-form" id="booking_form">
                @csrf

                <div class="waitlist-title">
                    <h5>Availability preference</h5>
                </div>

                <div class="whitebox">
                    <p class="waitlist-info">
                        <img src="{{ static_asset('frontend/assets/images/waitlist-calender.png') }}"> <span>Select date and
                            time</span>
                    </p>
                    <hr>
                    <div class="date">
                        <h5>Date</h5>
                    </div>

                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="any_date_button">Any Date </button>
                        <input type="radio" class="hidden" name="any_date" id="any_date" checked />
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_date_range_button">Select date
                            range</button>
                        <input type="radio" class="hidden" name="select_date_range" id="select_date_range" />
                    </span>

                    <div class="row d-none" id="sectione_date">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="From" name="from_date[]"
                                    id="from_date">
                            </div>
                        </div>
                        <div class="col-xs-1 dash">
                            <p>&mdash;</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="To" name="to_date[]" id="to_date">
                            </div>
                        </div>
                    </div>
                    <div class="date">
                        <h5>Time</h5>
                    </div>

                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="any_time_button">Any Time </button>
                        <input type="radio" class="hidden" name="any_time" id="any_time" checked />
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_time_range_button">Select time
                            range</button>
                        <input type="radio" class="hidden" name="select_time_range" id="select_time_range" />
                    </span>

                    <div class="row d-none" id="sectione_time">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="time" class="form-control" placeholder="From" name="from_time[]"
                                    id="from_time">
                            </div>
                        </div>
                        <div class="col-xs-1 dash">
                            <p>&mdash;</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="time" class="form-control" placeholder="To" name="to_time[]" id="to_time">
                            </div>
                        </div>
                    </div>

                    <div class="date ml-3">
                        <h5 id="add_preference"><labels>Add Preference</labels></h5>
                    </div>


                    <div  id="div_add_preference">
                    </div>

                    <div class="service-edit">
                        <h5>Services</h5>
                        <a href="">Edit</a>
                    </div>

                    @foreach ($booking_detail->booking_service_detailss as $service)
                        <div class="whitebox">
                            <div class="waitlist_info">
                                <h5>{{ $service->main_service->service_name_en }}</h5>
                                <p>{{ $service->sub_service->service_name_en }}</p>
                                <p class="time">{{ __('labels.30 min') }}</p>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </form>

            <button type="button" class="btn btn-success btn-block mt-3 mb-3">Book Waitlist</button>

            <div class="whitebox">
                <p class="instruction">{{ $data->cms_content[0]->$content }}</p>
            </div>
        </div>
    </section>
@endsection


@section('footer-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const anyDateButton = document.getElementById("any_date_button");
            const selectDateRangeButton = document.getElementById("select_date_range_button");
            const anyDateRadio = document.getElementById("any_date");
            const selectDateRangeRadio = document.getElementById("select_date_range");
            const sectionDate = document.getElementById("sectione_date");

            anyDateButton.addEventListener("click", function() {
                sectionDate.classList.add("d-none");
                anyDateRadio.checked = true;
                selectDateRangeRadio.checked = false;
            });

            selectDateRangeButton.addEventListener("click", function() {
                sectionDate.classList.remove("d-none");
                selectDateRangeRadio.checked = true;
                anyDateRadio.checked = false;
            });

            const anyTimeButton = document.getElementById("any_time_button");
            const selectTimeRangeButton = document.getElementById("select_time_range_button");
            const anyTimeRadio = document.getElementById("any_time");
            const selectTimeRangeRadio = document.getElementById("select_time_range");
            const sectionTime = document.getElementById("sectione_time");

            anyTimeButton.addEventListener("click", function() {
                sectionTime.classList.add("d-none");
                anyTimeRadio.checked = true;
                selectTimeRangeRadio.checked = false;
            });

            selectTimeRangeButton.addEventListener("click", function() {
                sectionTime.classList.remove("d-none");
                selectTimeRangeRadio.checked = true;
                anyTimeRadio.checked = false;
            });
        });



        $(document).ready(function() {
            var i = 1;
            $("#add_preference").click(function(e) {
                var html = '';
                html += `<div id="preference_${i}">`;

                // html += `<div class="date col-12">
                //             <h5>Date</h5>
                //         </div>

                //         <span class="button-radio">
                //             <button type="button" class="btn btn-light mb-3" id="any_date_button_${i}">Any Date</button>
                //             <input type="radio" class="hidden" name="any_date[`+ i +`]" id="any_date_`+ i +`" checked />
                //         </span>
                //         <span class="button-radio">
                //             <button type="button" class="btn btn-light mb-3" id="select_date_range_button_${i}">Select date range</button>
                //             <input type="radio" class="hidden" name="select_date_range[`+ i +`]" id="select_date_range_`+ i +`" />
                //         </span>

                //         <div class="row col-12" id="section_date_${i}">
                //             <div class="col-sm-4">
                //                 <div class="form-group">
                //                     <input type="date" class="form-control" placeholder="From" name="from_date[`+ i +`]" id="from_date_`+ i +`">
                //                 </div>
                //             </div>
                //             <div class="col-xs-1 dash">
                //                 <p>&mdash;</p>
                //             </div>
                //             <div class="col-sm-4">
                //                 <div class="form-group">
                //                     <input type="date" class="form-control" placeholder="To" name="to_date[`+ i +`]" id="to_date_`+ i +`">
                //                 </div>
                //             </div>
                //         </div>
                //         <div class="date col-12">
                //             <h5>Time</h5>
                //         </div>

                //         <span class="button-radio">
                //             <button type="button" class="btn btn-light mb-3" id="any_time_button_${i}">Any Time</button>
                //             <input type="radio" class="hidden" name="any_time[`+ i +`]" id="any_time_`+ i +`" checked />
                //         </span>
                //         <span class="button-radio">
                //             <button type="button" class="btn btn-light mb-3" id="select_time_range_button_${i}">Select time range</button>
                //             <input type="radio" class="hidden" name="select_time_range[`+ i +`]" id="select_time_range_`+ i +`" />
                //         </span>

                //         <div class="row col-12" id="section_time_${i}">
                //             <div class="col-sm-4">
                //                 <div class="form-group">
                //                     <input type="time" class="form-control" placeholder="From" name="from_time[`+ i +`]" id="from_time_`+ i +`">
                //                 </div>
                //             </div>
                //             <div class="col-xs-1 dash">
                //                 <p>&mdash;</p>
                //             </div>
                //             <div class="col-sm-4">
                //                 <div class="form-group">
                //                     <input type="time" class="form-control" placeholder="To" name="to_time[`+ i +`]" id="to_time_`+ i +`">
                //                 </div>
                //             </div>
                //         </div>
                //         <div class="col-12">
                //             <button type="button" class="btn btn-sm btn-primary remove-preference"><i class="fa fa-trash" aria-hidden="true"></i></button>
                //         </div>
                //     </div>`;

                html += ` <hr>
                    <div class="date">
                        <h5>Date</h5>
                    </div>

                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="any_date_button">Any Date </button>
                        <input type="radio" class="hidden" name="any_date[`+ i +`]" id="any_date_`+ i +`"  />
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_date_range_button">Select date
                            range</button>
                        <input type="radio" class="hidden" name="select_date_range[`+ i +`]" id="select_date_range_`+ i +`" />
                    </span>

                    <div class="row" id="sectione_date">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="From" name="from_date[`+ i +`]"
                                    id="from_date_`+ i +`">
                            </div>
                        </div>
                        <div class="col-xs-1 dash">
                            <p>&mdash;</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="To" name="to_date[`+ i +`]" id="to_date_`+ i +`">
                            </div>
                        </div>
                    </div>
                    <div class="date">
                        <h5>Time</h5>
                    </div>

                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="any_time_button">Any Time </button>
                        <input type="radio" class="hidden" name="any_time[`+ i +`]" id="any_time_`+ i +`"  />
                    </span>
                    <span class="button-radio">
                        <button type="button" class="btn btn-light mb-3" id="select_time_range_button">Select time
                            range</button>
                        <input type="radio" class="hidden" name="select_time_range[`+ i +`]" id="select_time_range_`+ i +`" />
                    </span>

                    <div class="row" id="sectione_time">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="time" class="form-control" placeholder="From" name="from_time[`+ i +`]"
                                    id="from_time_`+ i +`">
                            </div>
                        </div>
                        <div class="col-xs-1 dash">
                            <p>&mdash;</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="time" class="form-control" placeholder="To" name="to_time[`+ i +`]" id="to_time_`+ i +`">
                            </div>
                        </div>
                    </div>

                      <button type="button" class="btn btn-sm btn-primary remove-preference"><i class="fa fa-trash" aria-hidden="true"></i></button>`;


                $("#div_add_preference").append(html);
                i++;
            });

            $(document).on('click', '.remove-preference', function() {
                $(this).closest('div[id^="preference_"]').remove();
            });
        });
    </script>
@endsection
