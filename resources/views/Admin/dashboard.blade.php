@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>{{ __('labels.dashboard') }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">{{ __('labels.dashboard') }}</li>
                        <li class="breadcrumb-item active">{{ __('labels.dashboard') }} </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row widget-grid">


            {{-- booking start --}}



            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body primary"><span class="f-light">{{ __('labels.Total Today Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-primary f-12 f-w-500"><span>
                                        <h4>{{ $today_booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body success"><span class="f-light">{{ __('labels.Total Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-success f-12 f-w-500"><span>
                                        <h4>{{ $booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body secondary"><span
                                class="f-light">{{ __('labels.Total Pending Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-secondary f-12 f-w-500"><span>
                                        <h4>{{ $pending_booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body success"><span
                                class="f-light">{{ __('labels.Total Accepted Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-success f-12 f-w-500"><span>
                                        <h4>{{ $accept_booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body danger"><span
                                class="f-light">{{ __('labels.Total Rejected Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-danger f-12 f-w-500"><span>
                                        <h4>{{ $reject_booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>




            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body primary"><span
                                class="f-light">{{ __('labels.Total Finished Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-primary f-12 f-w-500"><span>
                                        <h4>{{ $finished_booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body warning"><span
                                class="f-light">{{ __('labels.Total Reschedule Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-warning f-12 f-w-500"><span>
                                        <h4>{{ $rescheduled_booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('booking.index') }}">
                    <div class="card small-widget">
                        <div class="card-body warning"><span
                                class="f-light">{{ __('labels.Total Cancelled Booking') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-warning f-12 f-w-500"><span>
                                        <h4>{{ $cancel_booking }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            {{-- booking end --}}


            {{--
                  </div>
                  <div class="row widget-grid"> --}}


            <div class="col-sm-2">
                <a href="{{ route('subadmin.index') }}">
                    <div class="card small-widget">
                        <div class="card-body warning"><span class="f-light">{{ __('labels.Total Sub Admin') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-warning f-12 f-w-500"><span>
                                        <h4>{{ $subadmin }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont  icofont-business-man-alt-2" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('barber.index') }}">
                    <div class="card small-widget">
                        <div class="card-body secondary"><span class="f-light">{{ __('labels.Total Barbar') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-secondary f-12 f-w-500"><span>
                                        <h4>{{ $barbers }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont  icofont-business-man-alt-2" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('customer.index') }}">
                    <div class="card small-widget">
                        <div class="card-body success"><span class="f-light">{{ __('labels.Total Customer') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-success f-12 f-w-500"><span>
                                        <h4>{{ $customers }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont icofont-users" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>










            <div class="col-sm-2">
                <a href="{{ route('subscription.index') }}">
                    <div class="card small-widget">
                        <div class="card-body primary"><span class="f-light">{{ __('labels.Total Subscription') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-primary f-12 f-w-500"><span>
                                        <h4>{{ $subscription }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont  icofont-ui-contact-list" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="{{ route('service.index') }}">
                    <div class="card small-widget">
                        <div class="card-body primary"><span
                                class="f-light">{{ __('labels.Total Main Services') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-primary f-12 f-w-500"><span>
                                        <h4>{{ $main_services }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont  icofont-ui-contact-list" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-2">
                <a href="{{ route('service.index') }}">
                    <div class="card small-widget">
                        <div class="card-body primary"><span class="f-light">{{ __('labels.Total Sub Services') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-primary f-12 f-w-500"><span>
                                        <h4>{{ $sub_services }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont  icofont-ui-contact-list" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-sm-2">
                <a href="{{ route('contact-us.index') }}">
                    <div class="card small-widget">
                        <div class="card-body primary"><span
                                class="f-light">{{ __('labels.Total Contact Inquiry') }}</span>
                            <div class="d-flex align-items-end gap-1">
                                <span class="font-primary f-12 f-w-500"><span>
                                        <h4>{{ $contactus }}</h4>
                                    </span></span>
                            </div>
                            <div class="bg-gradient">
                                {{-- <i class="icofont  icofont-ui-contact-list" style="font-size: 25px;"></i> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>






        </div>



        <div class="col-xxl-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <h5>{{ __('labels.Booking Overview') }} </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row m-0 overall-card overview-card">
                        <div class="col-xl-12 col-md-12 col-sm-12 p-0 box-col-7">
                            <div class="chart-right">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card-body p-0">
                                            <ul class="balance-data">

                                                <li><span class="circle bg-primary"> </span><span
                                                        class="f-light ms-1">{{ __('labels.Bookings') }}</span></li>

                                            </ul>
                                            <div class="current-sale-container order-container">
                                                <div class="overview-wrapper" id="orderoverviews"></div>
                                                <div class="back-bar-container">
                                                    <div id="order-bar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="card">
                <div class=" pb-0 card-no-border">

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                            <div class="dataTables_length" id="basic-1_length">
                                <h5> <b>

                                        {{ __('labels.Todays Booking') }}
                                    </b>
                            </div>


                            <table class="display dataTable no-footer" id="basic-1" role="grid"
                                aria-describedby="basic-1_info">
                                <thead>

                                    <th>{{ __('labels.Customer Detail') }}</th>
                                    <th>{{ __('labels.Barber Detail') }}</th>
                                    <th>{{ __('labels.Total Service') }}</th>
                                    <th>{{ __('labels.Booking Date') }}</th>

                                    <th>{{ __('labels.Start Time') }}</th>
                                    <th>{{ __('labels.End Time') }}</th>
                                    <th>{{ __('labels.Total Price') }}</th>
                                    <th>{{ __('labels.Status') }}</th>
                                </thead>
                                <tbody>


                                    @foreach ($todays_bookings as $todays_booking)
                                        <tr>
                                            <td>

                                                <ul>
                                                    <li>
                                                        <div class="media">
                                                          
                                                          @php
                                                     
                                                          $profileImage = $todays_booking->customer_detail->profile_image;
                                                         $webconfig= getWebsiteConfig();

                                                          $baseUrl = $webconfig->website_link; // Base URL for the public directory
                                                          $imageUrl = $profileImage 
                                                              ? $baseUrl . 'public/profile_image/' . $profileImage 
                                                              : $baseUrl . 'public/admin/assets/images/user/user.png';
                                                      @endphp
                                                            <img class="b-r-8 img-40" src="{{ $imageUrl }}"
                                                                alt="Generic image">



                                                            <div class="media-body">
                                                                <div class="row">
                                                                    <div class="col-xl-12">

                                                                        <h6 class="mt-0">&nbsp;&nbsp;
                                                                            {{ $todays_booking->customer_detail->first_name . ' ' . $todays_booking->customer_detail->last_name }}</span>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                                <p>&nbsp;&nbsp;
                                                                    {{ $todays_booking->customer_detail->email }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>

                                            </td>

                                            <td>

                                                <ul>
                                                    <li>
                                                        <div class="media">
                                                          @php
                                                     
                                                          $profileImage = $todays_booking->barber_detail->profile_image;
                                                         $webconfig= getWebsiteConfig();

                                                          $baseUrl = $webconfig->website_link; // Base URL for the public directory
                                                          $imageUrl = $profileImage 
                                                              ? $baseUrl . 'public/profile_image/' . $profileImage 
                                                              : $baseUrl . 'public/admin/assets/images/user/user.png';

                                                      @endphp
                                                            <img class="b-r-8 img-40" src="{{ $imageUrl }}"
                                                                alt="Generic image">



                                                            <div class="media-body">
                                                                <div class="row">
                                                                    <div class="col-xl-12">

                                                                        <h6 class="mt-0">&nbsp;&nbsp;
                                                                            {{ $todays_booking->barber_detail->first_name . ' ' . $todays_booking->barber_detail->last_name }}</span>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                                <p>&nbsp;&nbsp;
                                                                    {{ $todays_booking->barber_detail->email }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>

                                            <td>
                                                {{ count($todays_booking->booking_service_detailss) }}
                                            </td>


                                            <td>{{ date('Y-M-d', strtotime($todays_booking->booking_date)) }}
                                            </td>
                                            <td>{{ date('h:i A', strtotime($todays_booking->start_time)) }}
                                            </td>
                                            <td>{{ date('h:i A', strtotime($todays_booking->end_time)) }}
                                            </td>

                                            <td>{{ $todays_booking->total_price }}
                                            </td>

                                            <td>
                                                @php
                                                    $status = $todays_booking->status; // Assuming $row is your variable here
                                                @endphp

                                                @if ($status === 'pending')
                                                    <span class="badge bg-secondary">{{ __('labels.Pending') }}</span>
                                                @elseif ($status === 'reject')
                                                    <span class="badge bg-danger">{{ __('labels.Reject') }}</span>
                                                @elseif ($status === 'cancel')
                                                    <span class="badge bg-danger">{{ __('labels.Cancel') }}</span>
                                                @elseif ($status === 'accept')
                                                    <span class="badge bg-success">{{ __('labels.Accept') }}</span>
                                                @elseif ($status === 'finished')
                                                    <span class="badge bg-primary">{{ __('labels.Finished') }}</span>
                                                @elseif ($status === 'rescheduled')
                                                    <span class="badge bg-warning">{{ __('labels.Rescheduled') }}</span>
                                                @else
                                                    <span class="badge bg-dark">{{ __('labels.Unknown') }}</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- Container-fluid Ends-->



    <!-- Sidebar jquery-->
    <script src="{{ static_asset('admin/assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->

    <script src="{{ static_asset('admin/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/chart/apex-chart/moment.min.js') }}"></script>




    <script src="{{ static_asset('admin/assets/js/dashboard/default.js') }}"></script>
    <script>
        // Dynamic data from Laravel
        var orderCount = @json($orderCount); // Total orders
        var monthlyOrderCounts = @json($monthlyOrderCounts); // Monthly counts


        // overview chart
        var optionsoverview = {
            series: [{
                name: "Order",
                type: "area",
                data: monthlyOrderCounts.data, // Use dynamic data here
            }, ],
            chart: {
                height: 300,
                type: "line",
                stacked: false,
                toolbar: {
                    show: false,
                },
                dropShadow: {
                    enabled: true,
                    top: 2,
                    left: 0,
                    blur: 4,
                    color: "#000",
                    opacity: 0.08,
                },
            },
            stroke: {
                width: [2],
                curve: "smooth",
            },
            grid: {
                show: true,
                borderColor: "var(--chart-border)",
                strokeDashArray: 0,
                position: "back",
                xaxis: {
                    lines: {
                        show: true,
                    },
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0,
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: "50%",
                },
            },
            colors: ["#309BC9"],
            fill: {
                type: "gradient",
                gradient: {
                    shade: "light",
                    type: "vertical",
                    opacityFrom: 0.4,
                    opacityTo: 0,
                    stops: [0, 100],
                },
            },
            labels: monthlyOrderCounts.labels, // Use dynamic labels here
            markers: {
                size: 5,
                hover: {
                    size: 7,
                },
            },
            xaxis: {
                type: "category",
                tickAmount: 12, // Adjust this to show all months
                tickPlacement: "between",
                categories: monthlyOrderCounts.labels, // Use dynamic categories here
                tooltip: {
                    enabled: true, // Enable tooltip to show marker on hover
                },
                axisBorder: {
                    color: "var(--chart-border)",
                },
                axisTicks: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            yaxis: {
                min: 0,
                tickAmount: 6,
                tickPlacement: "between",
            },
            tooltip: {
                shared: false,
                intersect: false,
            },
            responsive: [{
                breakpoint: 1200,
                options: {
                    chart: {
                        height: 250,
                    },
                },
            }, ],
        };

        var chartoverview = new ApexCharts(
            document.querySelector("#orderoverviews"),
            optionsoverview
        );
        chartoverview.render();
    </script>

    <!-- Plugins JS Ends-->
@endsection
