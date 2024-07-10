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

            <div class="col-3">
                <div class="card small-widget">
                    <div class="card-body warning"><span class="f-light">{{ __('labels.Total Sub Admin') }}</span>
                        <div class="d-flex align-items-end gap-1">
                            <span class="font-warning f-12 f-w-500"><span>
                                    <h4>{{ $subadmin }}</h4>
                                </span></span>
                        </div>
                        <div class="bg-gradient">
                            <i class="icofont  icofont-business-man-alt-2" style="font-size: 25px;"></i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-3">
                <div class="card small-widget">
                    <div class="card-body secondary"><span class="f-light">{{ __('labels.Total Barbers') }}</span>
                        <div class="d-flex align-items-end gap-1">
                            <span class="font-secondary f-12 f-w-500"><span>
                                    <h4>{{ $barbers }}</h4>
                                </span></span>
                        </div>
                        <div class="bg-gradient">
                            <i class="icofont  icofont-business-man-alt-2" style="font-size: 25px;"></i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-3">
                <div class="card small-widget">
                    <div class="card-body success"><span class="f-light">{{ __('labels.Total Customers') }}</span>
                        <div class="d-flex align-items-end gap-1">
                            <span class="font-success f-12 f-w-500"><span>
                                    <h4>{{ $customers }}</h4>
                                </span></span>
                        </div>
                        <div class="bg-gradient">
                             <i class="icofont icofont-users" style="font-size: 25px;"></i>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-3">
                <div class="card small-widget">
                    <div class="card-body primary"><span class="f-light">{{ __('labels.Contact Us Inquiry') }}</span>
                        <div class="d-flex align-items-end gap-1">
                            <span class="font-primary f-12 f-w-500"><span>
                                    <h4>{{ $contactus }}</h4>
                                </span></span>
                        </div>
                        <div class="bg-gradient">
                            <i class="icofont  icofont-ui-contact-list" style="font-size: 25px;"></i>
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


    <!-- Plugins JS Ends-->
@endsection
