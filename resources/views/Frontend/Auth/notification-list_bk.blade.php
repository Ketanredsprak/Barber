@extends('Frontend.layouts.app')

@php
$auth = getauthdata();
$language = config('app.locale');
$name = 'page_name_' . $language;
@endphp

@section('content')
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


    <div class="container">
        <div class="row pt-75 pb-75">

            <div class="col-sm-12">

                @if (count($data_list) > 0)
                    @foreach ($data_list as $notification)
                        <div class="box shadow-sm rounded bg-white mb-3">
                            <div class="box-body p-2">
                                <div class="p-3 d-flex align-items-center osahan-post-header">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="{{ static_asset('frontend/assets/images/bell.png') }}" alt="" />
                                    </div>
                                    <div class="font-weight-bold mr-3">
                                        <div class="mb-2">{{ $notification->notification_type }}</div>
                                        <div class="small">{{ $notification->notification_message }}</div>
                                    </div>
                                    <span class="ml-auto mb-auto">
                                        <div class="text-right text-muted pt-1">
                                            {{ date('Y-M-d h:i A', strtotime($notification->created_at)) }}</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach



                    <div class="row">
                        <div class="col-sm-12 mt-5">
                            {!! $data_list->links() !!}
                        </div>
                    </div>
                @else
                    <div class="box shadow-sm rounded bg-white mb-3">
                        <div class="box-body p-2">
                            <div class="p-3 d-flex align-items-center osahan-post-header">
                                <div class="font-weight-bold mr-3">
                                    <div class="mb-2">{{ __('labels.No Nofitications Found') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </div>
@endsection
