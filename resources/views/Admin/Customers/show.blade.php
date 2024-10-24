@extends('Admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="page-title">

        <div class="row">

            <div class="col-6">



                <h4><a class="text-primary" href="{{ route('customer.index') }}" data-bs-toggle="card-remove"><i class="icofont icofont-arrow-left" style="font-size: 1.5em;"></i>

                    </a> {{ __('labels.Customer Detail') }}</h4>

            </div>

            <div class="col-6">

                <ol class="breadcrumb">



                    {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"

                                data-bs-target="#createcustomermodel"><i class="fa fa-plus" aria-hidden="true"></i>

                                Add New</button></li> --}}





                </ol>

            </div>

        </div>

    </div>

</div>



<!-- Container-fluid starts-->

<div class="container-fluid">

    <div class="edit-profile">

        <div class="row">

            <div class="col-xl-4">

                <div class="card">

                    <div class="card-header">



                        <h4 class="card-title mb-0">{{ __('labels.Customer Detail') }}</h4>

                        <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a></div>

                    </div>

                    <div class="card-body">

                        <form>

                            <div class="row mb-2">

                                <div class="profile-title">

                                    <div class="media">

                                        <img class="img-70 rounded-circle" alt="" src="@if (!empty($data->profile_image)) {{ static_asset('profile_image/' . $data->profile_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }} @endif">

                                        <div class="media-body">

                                            <h5 class="mb-1">{{ $data->first_name }} {{ $data->last_name }} </h5>

                                        </div>

                                    </div>

                                </div>

                            </div>





                            <div class="list-persons">

                                <div class="profile-mail">

                                    <div class="email-general">

                                        <ul>

                                            <li>{{ __('labels.Email') }} : <span class="font-primary first_name_0">

                                                    {{ $data->email }}</span></li>

                                            <li>{{ __('labels.Phone') }} : <span class="font-primary">

                                                    {{ $data->phone }}</span></li>

                                            <li>{{ __('labels.Gender') }} :<span class="font-primary"> <span class="birth_day_0">

                                                        @if ($data->gender == 'Male')

                                                        {{ __('labels.Male') }}

                                                        @else

                                                        {{ __('labels.Female') }}

                                                        @endif

                                                    </span>

                                            </li>

                                            <li>{{ __('labels.Location') }} : <span class="font-primary">

                                                    {{ $data->location }}</span></li>

                                            <li>{{ __('labels.Latitude') }} : <span class="font-primary">

                                                    {{ $data->latitude }}</span></li>

                                            <li>{{ __('labels.Longitude') }} : <span class="font-primary">

                                                    {{ $data->longitude }}</span></li>

                                            <li>{{ __('labels.Register Type') }} :



                                                <span class="font-primary">

                                                    @if ($data->register_type == "1")

                                                    {{ __('labels.App') }}

                                                    @else

                                                    {{ __('labels.Web') }}

                                                    @endif

                                                </span>

                                            </li>

                                            <li>{{ __('labels.Register Method') }} :

                                                <span class="font-primary">

                                                    @if ($data->register_method == "1")

                                                    {{ __('labels.System') }}

                                                    @elseif($data->register_method == "2")

                                                    {{ __('labels.Facebook') }}

                                                    @elseif($data->register_method == "2")

                                                    {{ __('labels.Google') }}

                                                    @else

                                                    {{ __('labels.Apple') }}

                                                    @endif

                                                </span>

                                            </li>

                                            </li>





                                            <li>{{ __('labels.Customer Status') }} :<span class="font-primary mobile_num_0">

                                                    @if ($data->is_approved == 1)

                                                    <span class="badge bg-primary">{{ __('labels.Pending') }}</span>

                                                    @elseif($data->is_approved == 2)

                                                    <span class="badge bg-success">{{ __('labels.Approved') }}</span>

                                                    @else

                                                    <span class="badge bg-danger">{{ __('labels.Suspend') }}</span>

                                                    @endif

                                            </li>



                                            <li>{{ __('labels.Referral Code') }} :<span class="font-primary city_0">{{ $data->referral_code }}</span></li>

                                            <li>{{ __('labels.Joining Date') }} :<span class="font-primary personality_0">{{ $data->created_at }}</span>

                                            </li>

                                            <li>

                                                {{ __('labels.Approved By') }} :

                                                <span class="font-primary personality_0">



                                                    @php

                                                    $approveId = $data->approved_by; // Assuming $data contains the approved_by field

                                                    $user = getUser($approveId); // Assuming getUser() is a function to retrieve user data

                                                    @endphp



                                                    @if ($user)

                                                    @foreach ($user as $u)

                                                    {{ $u->first_name }} {{ $u->last_name }}

                                                    @endforeach

                                                    @else

                                                    {{ __('Unknown') }}

                                                    <!-- Handle case where user is not found -->

                                                    @endif



                                                </span>

                                            </li>



                                        </ul>

                                    </div>

                                </div>

                            </div>



                        </form>

                    </div>

                </div>

            </div>





            <!-- new tab  -->

            <!-- Zero Configuration  Starts-->

            <div class="col-sm-8">

                <div class="card">

                    <div class="row product-page-main">

                        <div class="col-sm-12">

                            <ul class="nav nav-tabs border-tab nav-primary mb-0" id="top-tab" role="tablist">

                                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="false">Booking</a>

                                    <div class="material-border"></div>

                                </li>

                                <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false">Subscription</a>

                                    <div class="material-border"></div>

                                </li>





                            </ul>

                            <div class="tab-content" id="top-tabContent">

                                <div class="tab-pane fade active show" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">

                                    <div class="">

                                        <div class=" pb-0 card-no-border">



                                        </div>

                                        <div class="">

                                            <div class="table-responsive">

                                                <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">

                                                    <div class="dataTables_length" id="basic-1_length">



                                                    </div>





                                                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">

                                                        <thead>



                                                            <th>{{ __('labels.Booking Date') }}</th>



                                                            <th>{{ __('labels.Start Time') }}</th>

                                                            <th>{{ __('labels.End Time') }}</th>

                                                            <th>{{ __('labels.Total Price') }}</th>

                                                            <th>{{ __('labels.Status') }}</th>

                                                        </thead>

                                                        <tbody>





                                                            @foreach ($customer_bookings as $customer_booking)

                                                            <tr>

                                                                <!-- <td>

                                                        @php

                                                            $language = config('app.locale'); // Get current application locale

                                                            $customer_booking_name = 'customer_booking_name_' . $language; // Construct dynamic customer_booking name key



                                                            // Check if customer_booking detail exists and display the customer_booking name

                                                            $customer_booking_name_value =

                                                                $customer_booking->customer_booking_detail

                                                                    ->{$customer_booking_name} ?? '';

                                                        @endphp



                                                        {{ $customer_booking_name_value }}

                                                    </td> -->

                                                                <td>{{ date('Y-M-d', strtotime($customer_booking->booking_date)) }}

                                                                </td>

                                                                <td>{{ date('h:i A', strtotime($customer_booking->start_time)) }}

                                                                </td>

                                                                <td>{{ date('h:i A', strtotime($customer_booking->end_time)) }}

                                                                </td>



                                                                <td>{{ $customer_booking->total_price }}

                                                                </td>



                                                                <td>

                                                                    @php

                                                                    $status = $customer_booking->status; // Assuming $row is your variable here

                                                                    @endphp



                                                                    @if ($status === 'pending')

                                                                    <span class="badge bg-warning">{{ __('Pending') }}</span>

                                                                    @elseif ($status === 'reject')

                                                                    <span class="badge bg-danger">{{ __('Rejected') }}</span>

                                                                    @elseif ($status === 'cancel')

                                                                    <span class="badge bg-danger">{{ __('Cancelled') }}</span>

                                                                    @elseif ($status === 'accept')

                                                                    <span class="badge bg-success">{{ __('Accepted') }}</span>

                                                                    @elseif ($status === 'finished')

                                                                    <span class="badge bg-primary">{{ __('Finished') }}</span>

                                                                    @elseif ($status === 'rescheduled')

                                                                    <span class="badge bg-warning">{{ __('Rescheduled') }}</span>

                                                                    @else

                                                                    <span class="badge bg-dark">{{ __('Unknown') }}</span>

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

                                <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">



                                <div class="" style="margin-top: 2%;" >

                                            <div class="pb-0 card-no-border">

                                            </div>

                                            <div class="" >

                                                <div class="table-responsive">

                                                    <table class="display" id="basic-9">

                                                        <thead>

                                                            <tr>

                                                                <th>{{ __('labels.Subscription Name') }}</th>

                                                                <th>{{ __('labels.Start Time') }}</th>

                                                                <th>{{ __('labels.End Time') }}</th>

                                                                <th>{{ __('labels.Status') }}</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            @foreach ($userSubscriptions as $subscription)

                                                                <tr>

                                                                    <td>

                                                                        @php

                                                                            $language = config('app.locale'); // Get current application locale

                                                                            $subscription_name =

                                                                                'subscription_name_' . $language; // Construct dynamic subscription name key



                                                                            // Check if subscription detail exists and display the subscription name

                                                                            $subscription_name_value =

                                                                                $subscription->subscription_detail

                                                                                    ->{$subscription_name} ?? '';

                                                                        @endphp



                                                                        {{ $subscription_name_value }}

                                                                    </td>

                                                                    <td>{{ date('Y-M-d h:i A', strtotime($subscription->start_date_time)) }}

                                                                    </td>

                                                                    <td> {{ date('Y-M-d h:i A', strtotime($subscription->end_date_time)) }}

                                                                    </td>

                                                                    <td>

                                                                        @php

                                                                            $status = $subscription['status'];

                                                                        @endphp



                                                                        @if ($status === 'active')

                                                                            <span

                                                                                class="badge bg-success">{{ __('labels.Active') }}</span>

                                                                        @elseif ($status === 'expired')

                                                                            <span

                                                                                class="badge bg-dark">{{ __('labels.Expired') }}</span>

                                                                        @elseif ($status === 'cancelled')

                                                                            <span

                                                                                class="badge bg-danger">{{ __('labels.Cancelled') }}</span>

                                                                        @else

                                                                            <span

                                                                                class="badge bg-dark">{{ __('labels.Inactive') }}</span>

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

                    </div>

                </div>

            </div>

            <!-- Zero Configuration  Ends-->

        </div>

    </div>

</div>

<!-- Container-fluid Ends-->











</div>

@endsection
